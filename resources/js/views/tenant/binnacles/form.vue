<template>
    <el-dialog width="65%" :title="titleDialog" :visible="showDialog" :close-on-click-modal="false" @close="close" @open="create" append-to-body top="7vh">
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" :class="{'has-danger': errors.client_id}">
                        <label class="control-label">Cliente <span class="text-danger">*</span></label>
                        <el-select v-model="form.client_id" filterable>
                            <el-option v-for="option in clients" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.client_id" v-text="errors.client_id[0]"></small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group" :class="{'has-danger': errors.category_id}">
                        <label class="control-label">Categoria (Cuenta)</label>
                        <el-select v-model="form.category_id" filterable>
                            <el-option v-for="option in categorys" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
                        <!-- <el-input v-model="form.category_id" dusk="category_id"></el-input> -->
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
                         <el-select v-model="form.service_id" filterable>
                            <el-option v-for="option in services" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
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

            <div class="form-actions text-right pt-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
            </div>
        </form>

    </el-dialog>
</template>

<script>
    // import PercentagePerception from './partials/percentage_perception.vue'
    // import LotsForm from './partials/lots.vue'

    export default {
        props: ['showDialog', 'recordId', 'external'],
        // components: {LotsForm},

        data() {
            return {
                resource: 'binnacles',
                errors: {},
                form: {},
                // all_clients: [],
                clients: [],
                services: [],
                categorys: [],
                titleDialog: null,
            }
        },
        async created() {
            await this.initForm()
            await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    this.clients = response.data.clients
                    this.services = response.data.services
                    this.categorys = response.data.categorys

                    this.selectClient()

                })

            this.$eventHub.$on('reloadDataPersons', (client_id) => {
                this.reloadDataClients(client_id)
           })

        },

        methods: {

            selectClient(){
                let clients = _.find(this.clients, {'id': this.aux_client_id})
                this.form.client_id = (clients) ? clients.id : null
                this.aux_client_id = null
            },

            clickDelete(id) {

                this.$http.delete(`/${this.resource}/item-unit-type/${id}`)
                        .then(res => {
                            if(res.data.success) {
                                this.loadRecord()
                                this.$message.success('Se eliminó correctamente el registro')
                            }
                        })
                        .catch(error => {
                            if (error.response.status === 500) {
                                this.$message.error('Error al intentar eliminar');
                            } else {
                                console.log(error.response.data.message)
                            }
                        })

            },

            clickCancel(index) {
                this.form.item_unit_types.splice(index, 1)
                // this.initDocumentTypes()
                // this.showAddButton = true
            },
            initForm() {
                this.loading_submit = false,
                this.errors = {}
                this.form = {
                    establishment_id: null,
                    document_type_id: null,
                    series: null,
                    number: null,
                    aux_client_id:null,
                    date: moment().format('YYYY-MM-DD'),
                    start_time: null,//moment().format('YYYY-MM-DD HH:mm:ss'),
                    end_time: null,//moment().format('YYYY-MM-DD HH:mm:ss'),
                    hour: null,
                    client_id: null,
                    category_id:null,
                    service_id:null,
                    period:null,
                    description:null,
                    status:null,
                }
                // this.show_has_igv = true
                // this.purchase_show_has_igv = true
                // this.enabled_percentage_of_profit = false
            },

            calHora(){
                
                var fecha1 = moment(this.form.start_time)//moment('2020-06-01 10:00:00');
                var fecha2 = moment(this.form.end_time)//moment('2020-06-01 13:00:00');
                // console.log(fecha1)

                // console.log(fecha2.diff(fecha1,'hours','minutes','seconds')),

                this.form.hour = moment(fecha2.diff(fecha1,'hours','minutes','seconds'))
            },

            resetForm() {
                this.initForm()
                // this.form.sale_affectation_igv_type_id = (this.affectation_igv_types.length > 0)?this.affectation_igv_types[0].id:null
                // this.form.purchase_affectation_igv_type_id = (this.affectation_igv_types.length > 0)?this.affectation_igv_types[0].id:null
                this.setDefaultConfiguration()
            },
            create() {

                this.titleDialog = (this.recordId)? 'Editar Evento':'Nuevo Evento'
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                            // this.has_percentage_perception = (this.form.percentage_perception) ? true : false
                            // this.changeAffectationIgvType()
                            // this.changePurchaseAffectationIgvType()
                        })
                }

            },
            loadRecord(){
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                            // this.changeAffectationIgvType()
                            // this.changePurchaseAffectationIgvType()
                        })
                }
            },
            async submit() {
                // if(this.form.has_perception && !this.form.percentage_perception) return this.$message.error('Ingrese un porcentaje');

                // if(!this.recordId && this.form.lots_enabled){

                //     if(!this.form.lot_code)
                //         return this.$message.error('Código de lote es requerido');

                //     if(!this.form.date_of_due)
                //         return this.$message.error('Fecha de vencimiento es requerido si lotes esta habilitado.');
                // }

                // if(!this.recordId && this.form.series_enabled){

                //     if(this.form.lots.length > this.form.stock)
                //         return this.$message.error('La cantidad de series registradas es superior al stock');

                //     if(this.form.lots.length != this.form.stock)
                //         return this.$message.error('La cantidad de series registradas son diferentes al stock');
                // }

                this.loading_submit = true
                await this.$http.post(`/${this.resource}`, this.form)
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                            if (this.external) {
                                this.$eventHub.$emit('reloadDataItems', response.data.id)
                            } else {
                                this.$eventHub.$emit('reloadData')
                            }
                            this.close()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            console.log(error)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
            },
            close() {
                this.$emit('update:showDialog', false)
                this.resetForm()
            },
            reloadDataClients(client_id) {
                this.$http.get(`/${this.resource}/table/clients`).then((response) => {
                    this.aux_client_id = client_id
                    this.all_clients = response.data
                    this.selectClient()
                })
            },
        }
    }
</script>
