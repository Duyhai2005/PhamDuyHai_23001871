const catalogApp = {
  data() {
    return {
      sanPhamList: [
        { id: 1, ten: 'Tai nghe Bluetooth', gia: 450000, anh: 'assets/san-pham.svg', moTa: 'Tai nghe không dây gọn nhẹ, phù hợp học tập và nghe nhạc.', soLuongTon: 12 },
        { id: 2, ten: 'Bàn phím cơ', gia: 890000, anh: 'assets/san-pham.svg', moTa: 'Bàn phím có đèn nền, gõ êm và kết nối USB.', soLuongTon: 5 },
        { id: 3, ten: 'Chuột không dây', gia: 320000, anh: 'assets/san-pham.svg', moTa: 'Chuột không dây nhỏ gọn, dùng pin và có nút cuộn.', soLuongTon: 0 },
        { id: 4, ten: 'Đèn bàn LED', gia: 275000, moTa: 'Đèn bàn có thể điều chỉnh hướng sáng, phù hợp góc học tập.', soLuongTon: 7 }
      ]
    };
  }
};

if (typeof Vue !== 'undefined' && window.TheSanPham) {
  Vue.createApp(catalogApp).component('the-san-pham', window.TheSanPham).mount('#app');
}
