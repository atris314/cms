<template>
    <div>
    <div class="row form-group">
        <label for="statictitle" class="col-form-label col-sm-3 gray-text-color">استان: </label>
        <div class="col-sm-9">
            <select class="form-control-customize" name="province_id" v-model="province" @change="getAllCities()">
                <option value="1">آذربايجان شرقي</option>
                <option value="2">آذربايجان غربي</option>
                <option value="3">اردبيل</option>
                <option value="4">اصفهان</option>
                <option value="5">البرز</option>
                <option value="6">ايلام</option>
                <option value="7">بوشهر</option>
                <option value="8">تهران</option>
                <option value="9">چهارمحال بختياري</option>
                <option value="10">خراسان جنوبي</option>
                <option value="11">خراسان رضوي</option>
                <option value="12">خراسان شمالي</option>
                <option value="13">خوزستان</option>
                <option value="14">زنجان</option>
                <option value="15">سمنان</option>
                <option value="16">سيستان و بلوچستان</option>
                <option value="17">فارس</option>
                <option value="18">قزوين</option>
                <option value="19">قم</option>
                <option value="20">كردستان</option>
                <option value="21">كرمان</option>
                <option value="22">كرمانشاه</option>
                <option value="23">كهكيلويه و بويراحمد</option>
                <option value="24">گلستان</option>
                <option value="25">گيلان</option>
                <option value="26">لرستان</option>
                <option value="27">مازندران</option>
                <option value="28">مركزي</option>
                <option value="29">هرمزگان</option>
                <option value="30">همدان</option>
                <option value="31">يزد</option>
            </select>
        </div>
    </div>
    <div class="row form-group"  v-if="cities.length>0">
        <label for="statictitle" class="col-form-label col-sm-3 gray-text-color">شهر: </label>
        <div class="col-sm-9">
            <select class="form-control-customize" name="city_id">
                <option v-for="city in cities" :value="city.id">{{city.name}}</option>
            </select>

        </div>
    </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                province:'استان خود را انتخاب کنید',
                cities: [],
                flag : false,
            }
        },
        methods:{
            getAllCities: function () {
                axios.get('/api/cities/'+this.province).then(res =>{
                    this.cities = res.data.cities
                }).catch(err=>{
                    console.log(err)
                })
            },
        }
    }
</script>