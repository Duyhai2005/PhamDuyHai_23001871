const productApp = {
  data() {
    return {
      sanPhamList: [],
      sanPham: { name: '', price: null, stock: 0 },
      dangSua: false,
      idDangSua: null,
      thongBao: '',
      loi: ''
    };
  },
  methods: {
    async taiDanhSach() {
      try {
        const response = await fetch('api/products.php');
        const result = await response.json();

        if (!response.ok || !result.success) {
          throw new Error(result.message || 'Không thể tải danh sách sản phẩm.');
        }

        this.sanPhamList = result.data;
      } catch (error) {
        this.loi = error.message;
      }
    },
    dinhDangTien(gia) {
      return new Intl.NumberFormat('vi-VN').format(gia) + ' đồng';
    },
    async luuSanPham() {
      this.thongBao = '';
      this.loi = '';

      const method = this.dangSua ? 'PUT' : 'POST';
      const url = this.dangSua
        ? 'api/products.php?id=' + this.idDangSua
        : 'api/products.php';

      try {
        const response = await fetch(url, {
          method: method,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            name: this.sanPham.name,
            price: this.sanPham.price,
            stock: this.sanPham.stock
          })
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
          throw new Error(result.message || 'Không thể lưu sản phẩm.');
        }

        this.thongBao = result.message;
        this.lamMoi();
        await this.taiDanhSach();
      } catch (error) {
        this.loi = error.message;
      }
    },
    suaSanPham(item) {
      this.dangSua = true;
      this.idDangSua = item.id;
      this.sanPham = {
        name: item.name,
        price: item.price,
        stock: item.stock
      };
      this.thongBao = '';
      this.loi = '';
    },
    async xoaSanPham(id) {
      if (!window.confirm('Bạn có chắc muốn xóa sản phẩm này không?')) return;

      this.thongBao = '';
      this.loi = '';

      try {
        const response = await fetch('api/products.php?id=' + id, {
          method: 'DELETE'
        });
        const result = await response.json();

        if (!response.ok || !result.success) {
          throw new Error(result.message || 'Không thể xóa sản phẩm.');
        }

        this.thongBao = result.message;
        if (this.idDangSua === id) this.lamMoi();
        await this.taiDanhSach();
      } catch (error) {
        this.loi = error.message;
      }
    },
    lamMoi() {
      this.sanPham = { name: '', price: null, stock: 0 };
      this.dangSua = false;
      this.idDangSua = null;
    }
  },
  mounted() {
    this.taiDanhSach();
  }
};

if (typeof Vue !== 'undefined') Vue.createApp(productApp).mount('#app');
