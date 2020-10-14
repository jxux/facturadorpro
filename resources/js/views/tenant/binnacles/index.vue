<template>
    <div>
        <div class="page-header pr-0">
            <h2><a href="/dashboard"><i class="fas fa-tachometer-alt"></i></a></h2>
            <ol class="breadcrumbs">
                <li class="active"><span>Parte Diario</span></li>
            </ol>
            <div class="right-wrapper pull-right">
                <a :href="`/partdiary/create`" class="btn btn-custom btn-sm  mt-2 mr-2"><i class="fa fa-plus-circle"></i> Nuevo</a>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>Fecha</th>
                        <th>H. Inicio</th>
                        <th>H. Fin</th>
                        <th>Horas</th>
                        <th>Cliente</th>
                        <th>Categoria(Cuenta)</th>
                        <th>Servicio(C. Costo)</th>
                        <th>Periodo</th>
                        <th>Descripción</th>
                        <!-- <th>Creación</th> -->
                        <th class="text-center">Estado</th>
                    <tr>
                    <tr slot-scope="{ row }">
                        <!-- <td>{{ index }}</td> -->
                        <td>{{ row.date }} </td>
                        <td>{{ row.start_time }}</td>
                        <td>{{ row.end_time }}</td>
                        <td>{{ row.hour }}</td>
                        <!-- <td>"{{ moment.duration(row.end_time.diff(row.start_time)) }}"</td> -->
                        <td>{{ row.customer_work }}</td>
                        <td>{{ }}</td>
                        <td>{{ }}</td>
                        <td>{{ row.period }}</td>
                        <td>{{ row.description }}</td>
                        <!-- <td>{{ row.created_at }}</td> -->
                        <td>
                            <el-tag v-if="row.status === 0" effect="dark" type="danger" size="mini">{{ row.status }} %</el-tag>
                            <el-tag v-else-if="row.status === 25" effect="dark" type="danger" size="mini">{{ row.status }} %</el-tag>
                            <el-tag v-else-if="row.status === 50" effect="dark" type="info" size="mini">{{ row.status }} %</el-tag>
                            <el-tag v-else-if="row.status === 75" effect="dark" type="warning" size="mini">{{ row.status }} %</el-tag>
                            <el-tag v-else-if="row.status === 100" effect="plain" type="success" size="mini">{{ row.status }} %</el-tag>
                        </td>
                        <td class="text-right">
                            <!-- <button type="button" class="btn waves-effect waves-light btn-xs btn-info" @click.prevent="clickCreate(row.id)">Editar</button> -->
                            <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" @click.prevent="clickDelete(row.id)"><i class="el-icon-delete"></i></button>
                        </td>
                    </tr>
                </data-table>
            </div>

            <!-- <documents-voided :showDialog.sync="showDialogVoided"
                            :recordId="recordId"></documents-voided>

            <document-options :showDialog.sync="showDialogOptions"
                              :recordId="recordId"
                              :showClose="true"></document-options> -->
        </div>
    </div>
</template>

<script>

    // import DocumentsVoided from './partials/voided.vue'
    // import DocumentOptions from './partials/options.vue'
    import DataTable from '../../../components/DataTable.vue'
    import {deletable} from '../../../mixins/deletable'

    export default {
        mixins: [deletable],
        props:['typeUser'],
        components:{DataTable},
        // components: {DocumentsVoided, DocumentOptions, DataTable},
        data() {
            return {
                title: null,
                showDialogVoided: false,
                resource: 'binnacle',
                recordId: null,
                showDialogOptions: false

            }
        },
        created() {
        },
        methods: {

            clickVoided(recordId = null) {
                this.recordId = recordId
                this.showDialogVoided = true
            }, 
            clickDownload(download) {
                window.open(download, '_blank');
            },  
            clickOptions(recordId = null) {
                this.recordId = recordId
                this.showDialogOptions = true
            },

            clickCreate(recordId = null) {
                this.recordId = recordId
                this.showDialog = true
            },
            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            },
        }
    }
</script>