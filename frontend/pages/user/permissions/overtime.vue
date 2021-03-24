<template>
  <div>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <h1 class="heading">Overtime</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-md-12" style="margin-top: 100px">
          <el-card v-loading="getLoader">
            <div class="row" style="margin-bottom: 20px">
              <div class="col-md-3 offset-md-9">
                <el-input
                  placeholder="Cari"
                  v-model="search"
                  @change="searchData()"
                  size="mini"
                >
                  <i slot="prefix" class="el-input__icon el-icon-search"></i>
                </el-input>
              </div>
            </div>
            <vs-table striped>
              <template #thead>
                <vs-tr>
                  <vs-th>Date</vs-th>
                  <vs-th>Schedule In</vs-th>
                  <vs-th>Schedule Out</vs-th>
                  <vs-th>Status</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getOverTime.data" :data="tr">
                  <vs-td>
                    {{ formatDate(tr.date) }}
                  </vs-td>
                  <vs-td>
                    {{ formatHour(tr.schedule_in) }}
                  </vs-td>
                  <vs-td>
                    {{ formatHour(tr.schedule_out) }}
                  </vs-td>
                  <vs-td>
                    <span class="badge badge-primary" v-if="tr.status_id == 0"
                      >Waiting</span
                    >
                    <span
                      class="badge badge-success"
                      v-else-if="tr.status_id == 1"
                      >Accepted</span
                    >
                    <span class="badge badge-warning" v-else>Rejected</span>
                  </vs-td>
                  <vs-td>
                    <el-tooltip
                      v-if="tr.status_id == 0"
                      content="Edit"
                      placement="top-start"
                      effect="dark"
                    >
                      <el-button
                        size="mini"
                        @click="edit(tr)"
                        icon="fa fa-edit"
                      ></el-button>
                    </el-tooltip>
                    <el-tooltip
                      v-else
                      content="Edit"
                      placement="top-start"
                      effect="dark"
                    >
                      <el-button
                        disabled
                        size="mini"
                        icon="fa fa-edit"
                      ></el-button>
                    </el-tooltip>
                    <el-tooltip
                      v-if="tr.status_id == 0"
                      content="Delete"
                      placement="top-start"
                      effect="dark"
                    >
                      <el-button
                        size="mini"
                        type="primary"
                        @click="deleteCutiE(tr.id)"
                        icon="fa fa-trash"
                      >
                      </el-button>
                    </el-tooltip>
                    <el-tooltip
                      v-else
                      content="Delete"
                      placement="top-start"
                      effect="dark"
                    >
                      <el-button
                        disabled
                        size="mini"
                        type="primary"
                        icon="fa fa-trash"
                      >
                      </el-button>
                    </el-tooltip>
                  </vs-td>
                  <template #expand>
                    <vs-row>
                      <div class="con-content">
                        <h1>Reason</h1>
                        <div v-html="tr.reason">
                          {{ tr.reason }}
                        </div>
                      </div>
                      <div >
                        <vs-button
                          success
                          style="float: right; margin-left: 50px;"
                          :loading="globalLoader"
                          gradient
                          >Evidence</vs-button
                        >
                      </div>
                    </vs-row>
                  </template>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{ getOverTime.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getOverTime.total / table.max)"
                    />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
    </div>

    <el-tooltip
      class="item"
      effect="dark"
      content="Buat Overtime Permission Baru"
      placement="top-start"
    >
      <a
        class="float"
        @click="
          seDialog = true;
          titleDialog = 'Permohonan Izin Lembur';
          ey();
        "
      >
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>

    <vs-dialog
      v-model="seDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'"
      @close="resetForm()"
    >
      <template #header>
        <h1 class="not-margin">
          {{ titleDialog }}
        </h1>
      </template>
      <div class="con-form">
        <vs-row>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="12"
            style="padding: 5px"
          >
            <label>Date</label>
            <vs-input type="date" v-model="form.date"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
          <label>Schedule_in</label>
            <vs-input type="time" v-model="form.schedule_in" placeholder="Schedule_in"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Schedule_out</label>
            <vs-input type="time" v-model="form.schedule_out" placeholder="Schedule_out"></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Reason</label>
            <client-only>
              <vue-editor v-model="form.reason"></vue-editor>
            </client-only>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Upload Document</label>
            <el-upload
              :action="api_url + '/fake-upload'" :on-change="handleChangeFile" list-type="picture-card" accept="image/*"
            :file-list="file" :limit="1"
            >
              <i class="el-icon-plus"></i>
            </el-upload>
          </vs-col>
        </vs-row>
      </div>

      <template #footer>
        <div class="footer-dialog">
          <vs-row>
            <vs-col w="6" style="padding: 5px">
              <vs-button
                block
                :loading="btnLoader"
                @click="onSubmit('update')"
                v-if="isUpdate"
                >Update</vs-button
              >
              <vs-button
                block
                :loading="btnLoader"
                @click="onSubmit('store')"
                v-else
                >Simpan</vs-button
              >
            </vs-col>
            <vs-col w="6" style="padding: 5px">
              <vs-button
                block
                border
                @click="
                  seDialog = false;
                  resetForm();
                "
                >Batal</vs-button
              >
            </vs-col>
          </vs-row>
          <div>&nbsp;</div>
        </div>
      </template>
    </vs-dialog>
  </div>
</template>

<script>
import moment from 'moment';
  import { mapMutations, mapGetters } from "vuex";
  import { config } from "../../../global.config";

  export default {
    layout: "user",
    components: {},
    data() {
      return {
        api_url: config.baseApiUrl,
        table: {
          max: 10,
        },
        page: 1,
        active: 0,
        titleDialog: "",
        search: "",
        company_id: "",
        user_id: "",
        isUpdate: false,
        seDialog: false,
        btnLoader: false,
          files: "",
        form: {
          id: "",
          employee_id: "",
          date: "",
          schedule_in: "",
          schedule_out: "",
          reason: "",
        },
      }
    },
    mounted () {
      this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
      this.user_id = JSON.parse(JSON.stringify(this.$auth.user.id));
      this.$axios.get(`/getEmployee?user_id=${this.user_id}`).then((resp) => {
        this.form.employee_id = resp.data.data.id;
      });
      this.$store.dispatch("overtime/getUser", {
        user_id: this.user_id,
      });
    },
    methods: {
      formatDate(data) {
        return moment(data).format("DD MMMM YYYY")
      },
      formatHour(data) {
        return moment(data, "HH:mm:ss").format("HH:mm")
      },
      resetForm() {
        this.form = {
          id: "",
          employee_id: this.form.employee_id,
          date: "",
          schedule_in: "",
          schedule_out: "",
          reason: "",
        };
        this.isUpdate = false;
      },
      handleCurrentChange(val) {
        this.$store.commit("overtime/setPage", val);
        this.$store.dispatch("overtime/getUser", {
          user_id: this.user_id,
        });
      },
      handleChangeFile(file, fileList) {
        console.log(file);
        this.files = file.raw;
      },
      handleChangeSelect(data) {
        this.$store.dispatch("overtime/getUser", {
          user_id: this.user_id,
          showall: 0,
        });
      },
      onSubmit(type = "store") {
        this.btnLoader = true;
        let formData = new FormData();
        formData.append("employee_id", this.form.employee_id);
        formData.append("date", this.form.date);
        formData.append("schedule_in", this.form.schedule_in);
        formData.append("schedule_out", this.form.schedule_out);
        formData.append("reason", this.form.reason);
        if (this.files) {
            formData.append("file", this.files)
          }
        let url = "/lemburpermission";
        if (type == "update") {
          url = `lemburpermission/${this.form.id}/update`;
        }

        this.$axios
          .post(url, formData)
          .then((resp) => {
            if (resp.data.success) {
              this.$notify.success({
                title: "Success",
                message: `Berhasil ${
                  type == "store" ? "Menambah" : "Mengubah"
                } Shift Employee`,
              });
              this.resetForm();
              this.seDialog = false;
              this.$store.dispatch("overtime/getUser", {
                user_id: this.user_id,
              });
            }
          })
          .finally(() => {
            this.btnLoader = false;
          })
          .catch((err) => {
            let error = err.response.data.data;
            if (error) {
              this.showErrorField(error);
            } else {
              this.$notify.error({
                title: "Error",
                message: err.response.data.message,
              });
            }
          });
      },
      ey() {
        console.log(this.form.employee_id);
      }
    },
    computed: {
      ...mapGetters("overtime", ["getOverTime", "getLoader"]),
    },
    watch: {
      getOverTime(newValue, oldValue) {
        //
      },
      page(newValue, oldValue) {
        this.$store.commit("overtime/setPage", newValue);
        this.$store.dispatch("overtime/getUser", {
          user_id: this.user_id,
        });
      },
    },
  }
</script>

<style lang="scss" scoped>
  .heading {
    color: white;
    font-size: 25px;
    font-weight: bold;
  }
</style>
