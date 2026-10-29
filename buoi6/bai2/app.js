const bookingApp = {
  data() {
    return {
      hoTen: '', suatChieu: '09:00', loaiVe: 'thuong', soLuong: 1,
      combo: false, xacNhan: null
    };
  },
  computed: {
    giaVe() { return this.loaiVe === 'vip' ? 100000 : 70000; },
    hopLe() {
      return this.hoTen.trim().length > 0 && Number.isInteger(this.soLuong)
        && this.soLuong >= 1 && this.soLuong <= 10;
    },
    tongTien() {
      const soVe = Number.isInteger(this.soLuong) && this.soLuong >= 1 && this.soLuong <= 10 ? this.soLuong : 0;
      return this.giaVe * soVe + (this.combo ? 45000 : 0);
    }
  },
  methods: {
    dinhDangTien(value) { return new Intl.NumberFormat('vi-VN').format(value) + ' đồng'; },
    tang() {
      if (!Number.isInteger(this.soLuong) || this.soLuong < 1) this.soLuong = 1;
      else if (this.soLuong < 10) this.soLuong++;
    },
    giam() {
      if (!Number.isInteger(this.soLuong) || this.soLuong > 10) this.soLuong = 10;
      else if (this.soLuong > 1) this.soLuong--;
    },
    datLai() {
      Object.assign(this, { hoTen: '', suatChieu: '09:00', loaiVe: 'thuong', soLuong: 1, combo: false, xacNhan: null });
    },
    datVe() {
      if (!this.hopLe) return;
      this.xacNhan = {
        hoTen: this.hoTen.trim(), suatChieu: this.suatChieu,
        loaiVe: this.loaiVe === 'vip' ? 'VIP' : 'Thường',
        soLuong: this.soLuong, combo: this.combo, tongTien: this.tongTien
      };
    }
  }
};

if (typeof Vue !== 'undefined') Vue.createApp(bookingApp).mount('#app');
