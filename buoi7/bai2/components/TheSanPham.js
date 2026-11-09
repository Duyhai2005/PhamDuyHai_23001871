window.TheSanPham = {
  props: {
    ten: { type: String, required: true },
    gia: { type: Number, required: true },
    anh: { type: String, default: 'assets/san-pham.svg' },
    moTa: { type: String, required: true },
    soLuongTon: { type: Number, required: true }
  },
  data() {
    return { hienMoTa: false };
  },
  methods: {
    dinhDangTien(gia) { return new Intl.NumberFormat('vi-VN').format(gia) + ' đồng'; }
  },
  template: `
    <article class="product-card">
      <img class="product-image" :src="anh" :alt="'Ảnh ' + ten">
      <div class="product-content">
        <h2>{{ ten }}</h2>
        <p class="price">{{ dinhDangTien(gia) }}</p>
        <span class="stock" :class="soLuongTon > 0 ? 'in-stock' : 'out-stock'">
          {{ soLuongTon > 0 ? 'Còn hàng · ' + soLuongTon + ' sản phẩm' : 'Hết hàng' }}
        </span>
        <p v-if="hienMoTa" class="description">{{ moTa }}</p>
        <p v-else class="description">Nhấn “Xem mô tả” để biết thêm thông tin.</p>
        <div class="actions">
          <button type="button" @click="hienMoTa = !hienMoTa">{{ hienMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}</button>
          <button class="buy" type="button" :disabled="soLuongTon === 0">Mua</button>
        </div>
      </div>
    </article>
  `
};
