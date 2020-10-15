<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-info">
            <h3 class="my-0">Nuevo Evento</h3>
        </div>
        <div class="tab-content">
            <form autocomplete="off" @submit.prevent="submit">
                <div class="form-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors.date}">
                                <label class="control-label">Fecha <span class="text-danger">*</span></label>
                                <el-date-picker format="dd/MM/yyyy" v-model="form.date" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date" v-text="errors.date[0]"></small>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors.start_time}">
                                <label class="control-label">Hora de inicio <span class="text-danger">*</span></label>
                                <el-time-picker format="hh:mm A" v-model="form.start_time" value-format="yyyy-MM-dd HH:mm:00" :clearable="false"></el-time-picker>
                                <small class="form-control-feedback" v-if="errors.start_time" v-text="errors.start_time[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors.end_time}">
                                <!-- <p>{{form.hora}}</p> -->
                                <label class="control-label">Hora de fin <span class="text-danger">*</span></label>
                                <el-time-picker format="hh:mm A" v-model="form.end_time" value-format="yyyy-MM-dd HH:mm:00" :clearable="false"></el-time-picker>
                                <small class="form-control-feedback" v-if="errors.end_time" v-text="errors.end_time[0]"></small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" :class="{'has-danger': errors.customer_work_id}">
                                <label class="control-label">Cliente <span class="text-danger">*</span></label>
                                <el-select v-model="form.customer_work_id" filterable>
                                    <el-option v-for="option in suppliers" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.customer_work_id" v-text="errors.customer_work_id[0]"></small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" :class="{'has-danger': errors.category_id}">
                                <label class="control-label">Categoria (Cuenta)</label>
                                <!-- <el-select v-model="form.category_id">
                                    <el-option v-for="option in category" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select> -->
                                <el-input v-model="form.category_id" dusk="category_id"></el-input>
                                <small class="form-control-feedback" v-if="errors.category_id" v-text="errors.category_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" :class="{'has-danger': errors.internal_id}">
                                <label class="control-label">Servicio (Centro de Costo)
                                    <!-- <el-tooltip class="item" effect="dark" content="Código interno de la empresa para el control de sus productos" placement="top-start">
                                        <i class="fa fa-info-circle"></i>
                                    </el-tooltip> -->
                                </label>
                                <el-input v-model="form.service_id" dusk="service_id"></el-input>
                                <small class="form-control-feedback" v-if="errors.service_id" v-text="errors.service_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" :class="{'has-danger': errors.period}">
                                <label class="control-label">Periodo
                                    <!-- <el-tooltip class="item" effect="dark" content="Código proporcionado por SUNAT, campo obligatorio para exportaciones" placement="top">
                                        <i class="fa fa-info-circle"></i>
                                    </el-tooltip> -->
                                </label>
                                <el-date-picker format="MMMM-yyyy" v-model="form.period" type="month" value-format="yyyy-MM-01" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.period" v-text="errors.period[0]"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" :class="{'has-danger': errors.description}">
                                <label class="control-label">Descripción</label>
                                <el-input :rows="5" v-model="form.description" dusk="description" type="textarea"></el-input>
                                <small class="form-control-feedback" v-if="errors.description" v-text="errors.description[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" :class="{'has-danger': errors.status}">
                                <label class="control-label">Estado</label>
                                <el-slider v-model="form.status" :step="25" show-stops></el-slider>
                                <small class="form-control-feedback" v-if="errors.status" v-text="errors.status[0]"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions text-right mt-4">
                    <el-button @click.prevent="close()">Cancelar</el-button>
                    <el-button type="primary" native-type="submit" :loading="loading_submit">Generar</el-button>
                </div>
            </form>
        </div>

        <person-form :showDialog.sync="showDialogNewPerson"
                       type="customers-work"
                       :external="true"></person-form>

    </div>
</template>

<script>

    import PersonForm from '../persons/form.vue'
    import {functions, exchangeRate} from '../../../mixins/functions'

    export default {
        components: {PersonForm},
        mixins: [functions, exchangeRate],
        data() {
            return {
                resource: 'binnacle',
                showDialogAddItem: false,
                showDialogNewPerson: false,
                showDialogOptions: false,
                loading_submit: false,
                errors: {},
                form: {},
                aux_customer_work_id:null,
                document_types: [],
                currency_types: [],
                discount_types: [],
                charges_types: [],
                all_suppliers: [],
                suppliers: [],
                category:[],
                currency_type: {},
                purchaseNewId: null
            }
        },
        created() {

            this.initForm()
            
            this.$http.get(`/${this.resource}/tables`)
                .then(response => {

                    this.document_types = response.data.document_types_invoice
                    this.currency_types = response.data.currency_types
                    this.establishment = response.data.establishment
                    this.all_suppliers = response.data.suppliers
                    this.discount_types = response.data.discount_types
                    this.charges_types = response.data.charges_types
                    this.form.currency_type_id = (this.currency_types.length > 0)?this.currency_types[0].id:null
                    this.form.establishment_id = (this.establishment.id) ? this.establishment.id:null
                    this.form.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null

                    this.changeDocumentType()
                })

            this.$eventHub.$on('reloadDataPersons', (customer_work_id) => {
                this.reloadDataSuppliers(customer_work_id)
           })

        },

        methods: {

            
            filterSuppliers() {
                if(this.form.document_type_id === '01') {
                    this.suppliers = _.filter(this.all_suppliers, {'identity_document_type_id': '6'})
                    this.selectSupplier()

                } else {
                    this.suppliers = _.filter(this.all_suppliers, (c) => { return c.identity_document_type_id !== '6' })
                    this.selectSupplier()
                }
            },
            selectSupplier(){
                let supplier = _.find(this.suppliers, {'id': this.aux_customer_work_id})
                this.form.customer_work_id = (supplier) ? supplier.id : null
                this.aux_customer_work_id = null

            },
            initForm() {
                this.errors = {}
                this.form = {

                    establishment_id: null,
                    document_type_id: null,
                    series: null,
                    number: null,

                    date: moment().format('YYYY-MM-DD'),
                    start_time: null,//moment().format('YYYY-MM-DD HH:mm:ss'),
                    end_time: null,//moment().format('YYYY-MM-DD HH:mm:ss'),
                    hour: null,
                    customer_work_id: null,
                    category_id:null,
                    service_id:null,
                    period:null,
                    description:null,
                    status:null,

                }
            },

            calHora(){
                
                var fecha1 = moment(this.form.start_time)//moment('2020-06-01 10:00:00');
                var fecha2 = moment(this.form.end_time)//moment('2020-06-01 13:00:00');
                // console.log(fecha1)

                // console.log(fecha2.diff(fecha1,'hours','minutes','seconds')),

                this.form.hour = moment(fecha2.diff(fecha1,'hours','minutes','seconds'))
                
                //  = duracion

            },

            resetForm() {
                this.initForm()
            },

            changeDocumentType() {
                this.filterSuppliers()
            },

            submit() {
                this.calHora()
                this.loading_submit = true
                this.$http.post(`/${this.resource}`, this.form)
                    .then(response => {

                        if (response.data.success) {
                            this.resetForm()
                            this.purchaseNewId = response.data.data.id
                            this.showDialogOptions = true
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            this.$message.error(error.response.data.message)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
            },
            
            reloadDataSuppliers(customer_work_id) {
                this.$http.get(`/${this.resource}/table/customers-work`).then((response) => {
                    this.aux_customer_work_id = customer_work_id
                    this.all_suppliers = response.data
                    this.filterSuppliers()
                })
            },
        }
    }
</script>