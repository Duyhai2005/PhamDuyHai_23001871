const DongGioHang = {
  props: {
    sanPham: { type: Object, required: true }
  },
  emits: ['doi-so-luong', 'yeu-cau-xoa'],
  computed: {
    thanhTien() { return this.sanPham.donGia * this.sanPham.soLuong; }
  },
  methods: {
    dinhDangTien(gia) { return new Intl.NumberFormat('vi-VN').format(gia) + ' đồng'; },
    tangSoLuong() {
      if (Number.isInteger(this.sanPham.soLuong) && this.sanPham.soLuong < 99) {
        this.$emit('doi-so-luong', this.sanPham.id, this.sanPham.soLuong + 1);
      }
    },
    giamSoLuong() {
      if (Number.isInteger(this.sanPham.soLuong) && this.sanPham.soLuong > 1) {
        this.$emit('doi-so-luong', this.sanPham.id, this.sanPham.soLuong - 1);
      }
    },
    xoa() { this.$emit('yeu-cau-xoa', this.sanPham.id); }
  },
  template: `
    <tr>
      <td>{{ sanPham.ten }}</td>
      <td>{{ dinhDangTien(sanPham.donGia) }}</td>
      <td>
        <div class="quantity">
          <button type="button" :disabled="sanPham.soLuong <= 1" :aria-label="'Giảm số lượng ' + sanPham.ten" @click="giamSoLuong">−</button>
          <span class="quantity-value">{{ sanPham.soLuong }}</span>
          <button type="button" :disabled="sanPham.soLuong >= 99" :aria-label="'Tăng số lượng ' + sanPham.ten" @click="tangSoLuong">+</button>
        </div>
      </td>
      <td>{{ dinhDangTien(thanhTien) }}</td>
      <td><button class="delete" type="button" :aria-label="'Xóa ' + sanPham.ten" @click="xoa">Xóa</button></td>
    </tr>
  `
};

const cartApp = {
  data() {
    return {
      gioHang: [
        { id: 1, ten: 'Bút bi', donGia: 5000, soLuong: 2 },
        { id: 2, ten: 'Quyển vở', donGia: 12000, soLuong: 3 }
      ]
    };
  },
  computed: {
    tongSoLuong() { return this.gioHang.reduce((tong, sanPham) => tong + sanPham.soLuong, 0); },
    tongTien() { return this.gioHang.reduce((tong, sanPham) => tong + sanPham.donGia * sanPham.soLuong, 0); }
  },
  methods: {
    dinhDangTien(gia) { return new Intl.NumberFormat('vi-VN').format(gia) + ' đồng'; },
    doiSoLuong(id, soLuongMoi) {
      if (!Number.isInteger(soLuongMoi) || soLuongMoi < 1 || soLuongMoi > 99) return;
      const coSanPham = this.gioHang.some(sanPham => sanPham.id === id);
      if (!coSanPham) return;
      this.gioHang = this.gioHang.map(sanPham => sanPham.id === id ? { ...sanPham, soLuong: soLuongMoi } : sanPham);
    },
    xoaSanPham(id) {
      this.gioHang = this.gioHang.filter(sanPham => sanPham.id !== id);
    }
  }
};

if (typeof Vue !== 'undefined') {
  Vue.createApp(cartApp).component('dong-gio-hang', DongGioHang).mount('#app');
}
