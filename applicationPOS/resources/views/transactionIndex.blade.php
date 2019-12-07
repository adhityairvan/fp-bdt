@extends('template.template')
@section('css')
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    @endsection
@section('title')
    Transactions
@endsection
@section('title-body')
    Your Shop's Transactions
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12" id="form">
            <hr>
            <h3>New Transaction</h3>
            <h5>Add new Item to transaction @{{ tipeBarang }}</h5>
            <div class="row">
                <div class="form-group col">
                    <label for="tipeBarang">Tipe Barang</label>
                    <select class="form-control" id="tipeBarang" name="tipeBarang" v-model="tipeBarang">
                        <option value="" disabled></option>
                        <option value="minuman">Minuman</option>
                        <option value="makanan">Makanan</option>
                        <option value="snack">Snack</option>
                        <option value="rokok">Rokok</option>
                    </select>
                </div>
                <div class="form-group col" id="wraperBarang">
                    <label for="namaBarang">Nama Barang</label>
                    <select class="form-control" id="namaBarang" name="namaBarang" v-model="namaBarang" :disabled="inputDisable">
                        <option value="" disabled>Please Select</option>
                        <option v-for="option in optionNamaBarang" v-bind:value="{id: option.value, name: option.text, harga: option.harga}">
                            @{{ option.text }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="number" class="form-control" name="jumlah" id="jumlah" v-model="jumlah">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button class="btn btn-primary" id="addToCart" v-on:click="addItem">Add Item to transaction</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="cartTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item,index) in cart">
                                <td>@{{ item.barang }}</td>
                                <td>@{{ item.jumlah }}</td>
                                <td>@{{ item.harga* item.jumlah }}</td>
                                <td><button class="btn btn-danger" v-on:click="removeItem(index)">Delete</button></td>
                            </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th>Rp @{{ totalCart }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 offset-8">
                    <button class="btn btn-primary btn-block" v-on:click="submit">Finish Transaction</button>
                </div>
            </div>
        </div>
    </div>
    @endsection

@section('script')
    <!-- Page level plugins -->
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cartTable').DataTable({
                bInfo: false,
                paging: false,
                searching: false,
                ordering: false,
                columnDefs: [
                    { width: '60%', targets: 0 },
                    { width: '15%', targets: 1 }
                ],
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        var form = new Vue({
            el: '#form',
            data: {
                tipeBarang: '',
                inputDisable: true,
                optionNamaBarang:[],
                namaBarang: '',
                jumlah: 0,
                cart: [],
            },
            methods: {
                addItem: function(){
                    this.cart.push({
                        barang: this.namaBarang.name,
                        harga: this.namaBarang.harga,
                        jumlah: this.jumlah,
                        id: this.namaBarang.id
                    })
                },
                removeItem(index){
                    this.cart.splice(index,1);
                },
                submit: function() {
                    const data = this.cart.map((item) => {
                        return {id: item.id, jumlah: item.jumlah, total: item.jumlah*item.harga}
                    });
                    fetch('/transaction/store', {
                        method: 'POST',
                        body: JSON.stringify({ cart: data }),
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
                    }).then(response => {
                        if (!response.ok) {
                            alert("ERROR HAPPENED");
                        }
                        response.json()
                            .then(status => {
                                // console.log(status);
                                alert(status.status);
                                location.reload(true);
                            })
                    })
                }
            },
            watch: {
                tipeBarang: function (newInput, oldInput){
                    fetch('/api/item/listItem/'+newInput)
                        .then((response) => {
                            if(!response.ok){
                                alert('SOME ERROR HAPPENED');
                            }
                            response.json()
                                .then((json) => {
                                    this.optionNamaBarang = [];
                                    json.forEach((item) => {
                                        this.optionNamaBarang.push({value: item.id, text: item.nama_barang, harga:item.harga});
                                    });
                                    this.inputDisable = false;
                                })
                        })
                }
            },
            computed:{
                totalCart: function(){
                    if(!this.cart.length) return 0;
                    return this.cart.reduce((total,item) => {
                        return total+(parseInt(item.harga)*item.jumlah);
                    },0)
                },
            }
        });

    </script>
    @endsection
