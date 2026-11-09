const productApp = {
  data() {
    return {
      trangThai: 'Đang tải...',
      danhMuc: ['Điện tử', 'Phụ kiện', 'Gia dụng'],
      danhSachSanPham: [
        { id: 1, ten: 'Tai nghe Bluetooth', gia: 450000, danhMuc: 'Điện tử', tonKho: 12 },
        { id: 2, ten: 'Bàn phím cơ', gia: 890000, danhMuc: 'Điện tử', tonKho: 5 },
        { id: 3, ten: 'Chuột không dây', gia: 320000, danhMuc: 'Phụ kiện', tonKho: 18 },
        { id: 4, ten: 'Lót chuột', gia: 95000, danhMuc: 'Phụ kiện', tonKho: 0 },
        { id: 5, ten: 'Đèn bàn LED', gia: 275000, danhMuc: 'Gia dụng', tonKho: 7 },
        { id: 6, ten: 'Bình giữ nhiệt', gia: 210000, danhMuc: 'Gia dụng', tonKho: 0 }
      ],
      tuKhoa: '',
      danhMucChon: 'tat-ca',
      sapXep: 'gia-tang',
      sanPhamMoi: { ten: '', gia: null, danhMuc: 'Điện tử', tonKho: 0 },
      loiThem: '',
      thongBaoTimKiem: ''
    };
  },
  computed: {
    sanPham() { return this.danhSachSanPham; },
    sanPhamHienThi() {
      const tuKhoa = this.tuKhoa.trim().toLocaleLowerCase('vi');
      const ketQua = this.danhSachSanPham.filter(sanPham => {
        const dungTen = sanPham.ten.toLocaleLowerCase('vi').includes(tuKhoa);
        const dungDanhMuc = this.danhMucChon === 'tat-ca' || sanPham.danhMuc === this.danhMucChon;
        return dungTen && dungDanhMuc;
      });
      return ketQua.sort((a, b) => this.sapXep === 'gia-tang' ? a.gia - b.gia : b.gia - a.gia);
    },
    soSanPhamHienThi() { return this.sanPhamHienThi.length; },
    tongGiaTriTonKho() {
      return this.sanPhamHienThi.reduce((tong, sanPham) => tong + sanPham.gia * sanPham.tonKho, 0);
    }
  },
  watch: {
    tuKhoa(giaTri) {
      const soKyTu = giaTri.trim().length;
      this.thongBaoTimKiem = soKyTu === 1 ? 'Bạn đã nhập 1 ký tự. Hãy nhập thêm để tìm kiếm chính xác hơn.' : '';
    }
  },
  methods: {
    dinhDangTien(gia) { return new Intl.NumberFormat('vi-VN').format(gia) + ' đồng'; },
    themSanPham() {
      const ten = this.sanPhamMoi.ten.trim();
      const gia = this.sanPhamMoi.gia;
      const tonKho = this.sanPhamMoi.tonKho;
      if (!ten) {
        this.loiThem = 'Tên sản phẩm không được để trống.';
        return;
      }
      if (typeof gia !== 'number' || !Number.isFinite(gia) || gia <= 0) {
        this.loiThem = 'Giá phải lớn hơn 0.';
        return;
      }
      if (!Number.isInteger(tonKho) || tonKho < 0) {
        this.loiThem = 'Số lượng tồn phải là số nguyên không âm.';
        return;
      }
      const idMoi = Math.max(0, ...this.danhSachSanPham.map(sanPham => sanPham.id)) + 1;
      this.danhSachSanPham.push({ id: idMoi, ten, gia, danhMuc: this.sanPhamMoi.danhMuc, tonKho });
      this.sanPhamMoi = { ten: '', gia: null, danhMuc: 'Điện tử', tonKho: 0 };
      this.loiThem = '';
    },
    xoaSanPham(id) {
      const sanPham = this.danhSachSanPham.find(item => item.id === id);
      if (!sanPham || !window.confirm(`Bạn có chắc muốn xóa sản phẩm "${sanPham.ten}" không?`)) return;
      this.danhSachSanPham = this.danhSachSanPham.filter(item => item.id !== id);
    }
  },
  mounted() { this.trangThai = 'Sẵn sàng'; }
};

if (typeof Vue !== 'undefined') Vue.createApp(productApp).mount('#app');
