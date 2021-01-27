<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index: -1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Master User</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
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
                  <vs-th>Username</vs-th>
                  <vs-th>Email</vs-th>
                  <vs-th>User</vs-th>
                  <vs-th>Admin</vs-th>
                  <vs-th>Status</vs-th>
                  <vs-th>Action</vs-th>
                </vs-tr>
              </template>
              <template #tbody>
                <vs-tr :key="i" v-for="(tr, i) in getUsers.data" :data="tr">
                  <vs-td>
                    {{ tr.username }}
                  </vs-td>
                  <vs-td>
                    {{ tr.email }}
                  </vs-td>
                  <vs-td>
                    {{ tr.name }}
                  </vs-td>
                  <vs-td>
                    <span class="badge badge-success" v-if="tr.admin"
                      >Aktif</span
                    >
                    <span class="badge badge-warning" v-else>Non Aktif</span>
                  </vs-td>
                  <vs-td>
                    <span class="badge badge-success" v-if="tr.aktif"
                      >Aktif</span
                    >
                    <span class="badge badge-warning" v-else>Non Aktif</span>
                  </vs-td>

                  <vs-td>
                    <el-tooltip
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
                      content="Delete"
                      placement="top-start"
                      effect="dark"
                    >
                      <el-button
                        size="mini"
                        type="primary"
                        @click="deleteUser(tr.id)"
                        icon="fa fa-trash"
                      >
                      </el-button>
                    </el-tooltip>
                  </vs-td>
                </vs-tr>
              </template>
              <template #footer>
                <vs-row>
                  <vs-col w="2">
                    <small>Total : {{ getUsers.total }} Data</small>
                  </vs-col>
                  <vs-col w="10">
                    <vs-pagination
                      v-model="page"
                      :length="Math.ceil(getUsers.total / table.max)"
                    />
                  </vs-col>
                </vs-row>
              </template>
            </vs-table>
          </el-card>
        </div>
      </div>
    </div>

    <!-- Floating Button -->
    <el-tooltip
      class="item"
      effect="dark"
      content="Buat Schedule Baru"
      placement="top-start"
    >
      <a
        class="float"
        @click="
          request = true;
          userDialog = true;
          titleDialog = 'Tambah User';
        "
      >
        <i class="el-icon-plus my-float"></i>
      </a>
    </el-tooltip>
    <!-- End floating button -->

    <!-- <el-dialog :title="titleDialog" :visible.sync="shiftDialog"
      :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'" @closed="resetForm()">
      <el-form label-width="auto" ref="form" :model="form" size="mini">
        <el-form-item label="Hari">
          <el-input v-model="form.hari"></el-input>
        </el-form-item>
        <el-form-item label="Schedule In">
          <el-time-picker v-model="form.schedule_out"></el-time-picker>
        </el-form-item>
        <el-form-item size="large">
          <el-button type="primary" :loading="btnLoader" @click="onSubmit('update')" v-if="isUpdate">Update</el-button>
          <el-button type="primary" :loading="btnLoader" @click="onSubmit" v-else>Simpan</el-button>
          <el-button @click="shiftDialog = false">Batal</el-button>
        </el-form-item>
      </el-form>
    </el-dialog> -->

    <vs-dialog
      v-model="userDialog"
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
            w="6"
            style="padding: 5px"
          >
            <label>Username</label>
            <vs-input
              type="text"
              v-model="form.username"
              placeholder="Username"
            ></vs-input>
          </vs-col>
          <vs-col
            v-if="this.request"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Name</label>
            <vs-input
              type="text"
              v-model="form.name"
              placeholder="Name"
            ></vs-input>
          </vs-col>
          <vs-col
            v-if="this.request"
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Password</label>
            <vs-input
              type="password"
              v-model="form.password"
              placeholder="Password"
            ></vs-input>
          </vs-col>
          <vs-col
            vs-type="flex"
            vs-justify="center"
            vs-align="center"
            w="6"
            style="padding: 5px"
          >
            <label>Email</label>
            <vs-input
              type="text"
              v-model="form.email"
              placeholder="Email"
            ></vs-input>
          </vs-col>
          <vs-row>
            <vs-col w="2">
              <label>Admin</label>
            </vs-col>
            <vs-col w="10">
              <vs-switch style="width: 20px" v-model="form.admin" />
            </vs-col>
            <vs-col w="2">
              <label>Aktif</label>
            </vs-col>
            <vs-col w="10">
              <vs-switch style="width: 20px" v-model="form.aktif" />
            </vs-col>
          </vs-row>
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
                  userDialog = false;
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
import { mapMutations, mapGetters } from "vuex";

import { config } from "../../../global.config";

export default {
  layout: "admin",
  components: {},
  data() {
    return {
      api_url: config.baseApiUrl,
      company_id: "",
      table: {
        max: 10,
      },
      request:false,
      page: 1,
      titleDialog: "Edit User",
      search: "",
      company_id: JSON.parse(JSON.stringify(this.$auth.user.company_id)),
      isUpdate: false,
      userDialog: false,
      btnLoader: false,
      form: {
        id: "",
        username: "",
        email: "",
        name: "",
        password: "",
        admin: "true",
        aktif: "true",
      },
    };
  },
  mounted() {
    this.company_id = JSON.parse(JSON.stringify(this.$auth.user.company_id));
    this.$store.dispatch("user/getAll", {
      company_id: this.company_id,
    });
    this.$axios.get(`/users?company_id=${this.company_id}`).then((resp) => {
      console.log(resp);
    });
  },
  methods: {
    // searchData(){
    //   this.$store.dispatch('schedule/getAll', {
    //     search: this.search,
    //     company_id: this.company_id
    //   });
    // },
    edit(data) {
      // console.log(moment(data.schedule_in,"HH:mm:ss").format("HH:mm"))
      this.form.id = data.id;
      this.form.username = data.username;
      this.form.email = data.email;
      this.form.admin = data.admin;
      this.form.aktif = data.aktif;
      this.userDialog = true;
      this.titleDialog = "Edit User Data";
      this.isUpdate = true;
    },
    resetForm() {
      this.form = {
        id: "",
        username: "",
        email: "",
        name: "",
        password: "",
        admin: "aktif",
        aktif: "aktif"
      };
      this.isUpdate = false;
    },
    handleCurrentChange(val) {
      this.$store.commit("user/setPage", val);
      this.$store.dispatch("user/getAll", {
        company_id: this.company_id,
      });
    },
    onSubmit(type = "store") {
      this.btnLoader = true;
      let formData = new FormData();
      // formData.append("id", this.form.id);
      formData.append("company_id", this.company_id);
      formData.append("user", this.user);
      formData.append("password", this.form.password);
      formData.append("username", this.form.username);
      formData.append("name", this.form.name);
      formData.append("email", this.form.email);
      formData.append("admin", this.form.admin ? 1 : 0);
      formData.append("aktif", this.form.aktif ? 1 : 0);
      let url = "/user/store";
      if (type == "update") {
        url = `/user/update/${this.form.id}`;
      }

      this.$axios
        .post(url, formData)
        .then((resp) => {
          if (resp.data.success) {
            this.$notify.success({
              title: "Success",
              message: `Berhasil ${
                type == "store" ? "Menambah" : "Mengubah"
              } User`,
            });
            this.resetForm();
            this.userDialog = false;
            this.$store.dispatch("user/getAll", {
              company_id: this.company_id,
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
    deleteUser(id) {
      this.$swal({
        title: "HEY WAIT!, HEY HOLD ON!",
        text: "Are you serious to delete this cutie data ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes Yes Yes",
        cancelButtonText: "Yes but actually NO!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$axios
            .delete(`/user/delete/${id}`)
            .then((resp) => {
              if (resp.data.success) {
                this.$notify.success({
                  title: "Success",
                  message: "Berhasil Menghapus Data",
                });
                this.userDialog = false;
                this.$store.dispatch("user/getAll", {
                  defaultPage: true,
                  company_id: this.company_id,
                });
              }
            })
            .finally(() => {
              //
            })
            .catch((err) => {
              this.$notify.error({
                title: "Error",
                message: err.response.data.message,
              });
            });
        }
      });
    },
    // formatTime(time){
    //   return moment(time, "HH:mm:ss").format('HH:mm');
    // }
  },
  computed: {
    ...mapGetters("user", ["getUsers", "getLoader"]),
  },
  watch: {
    // getSchedule(newValue, oldValue) {
    // },
    // search(newValue, oldValue) {
    // this.$store.dispatch('goverment/getAll', {
    //   search: newValue
    // });
    // },
    // page(newValue, oldValue) {
    //   this.$store.commit('schedule/setPage', newValue)
    //   this.$store.dispatch('schedule/getAll', {
    //     company_id: this.company_id
    //   });
    // }
  },
};
</script>

<style lang="scss" scoped>
.heading {
  color: white;
  font-size: 25px;
  font-weight: bold;
}
</style>
