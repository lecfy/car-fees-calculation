<template>
  <h2>Enter the price and select type of your vehicle</h2>

  <label for="price" class="form-label">Price</label>
  <div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1">$</span>
    <input type="number" v-model="price" class="form-control" placeholder="1000" step="1000">
  </div>

  <label for="price" class="form-label">Type</label>
  <select class="form-select" v-model="type">
    <option value="Common">Common</option>
    <option value="Luxury">Luxury</option>
  </select>

  <div class="mt-4">
    <h2>Fees & Total</h2>
    <table class="table table-bordered">
      <thead></thead>
      <tbody>

        <tr>
          <td>Basic Fee</td>
          <td>${{ fees?.basic_fee ?? 0 }}</td>
        </tr>

        <tr>
          <td>Special Fee</td>
          <td>${{ fees?.special_fee ?? 0 }}</td>
        </tr>

        <tr>
          <td>Association Fee</td>
          <td>${{ fees?.association_fee ?? 0}}</td>
        </tr>

        <tr>
          <td>Storage Fee</td>
          <td>${{ fees?.storage_fee ?? 0}}</td>
        </tr>

        <tr>
          <td >Total Fees</td>
          <td>${{ feesTotal}}</td>
        </tr>

        <tr>
          <td class="fw-bold">Total</td>
          <td>${{ total }}</td>
        </tr>


      </tbody>
    </table>
  </div>

</template>

<script>
export default {
  data() {
    return {
      price: '',
      type: 'Common',
      fees: null,
      feesTotal: 0,
      total: 0,
    }
  },

  watch: {
    price() {
      this.calculateFees()
    },
    type() {
      this.calculateFees()
    }
  },

  methods: {
    calculateFees() {
      if (!this.price > 0) { return }
      if (this.type !== 'Common' && this.type !== 'Luxury') { return }

      fetch('http://localhost:8000/api.php', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          price: this.price,
          type: this.type,
        }),
      })
          .then(res => res.json())
          .then(data => {
            this.fees = data.feesList ?? null
            this.feesTotal = data.feesTotal
            this.total = data.total
          })
          .catch(err => console.log(err));
    }
  }
}
</script>