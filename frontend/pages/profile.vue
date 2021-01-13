<template>
  <div>
    <div class="header bg-primary pb-6" style="z-index:-1">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <h1 class="heading">Profil</h1>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--5">
      <div class="row">
        <div class="col-md-12">
          <vs-button @click="tambahDialog = true" icon dark shadow style="float:right; margin-left:-30px; margin-top:10px" >
            <i class='bx bx-edit'></i>
          </vs-button>
          <el-card style="margin-top:20px">
            <div class="text-center">
              <el-avatar size="large" style="width:100px; height:100px" :src="form.foto_url"></el-avatar>
              <br>
              <h3>{{form.nama}} ({{form.nip}})</h3>
              <span class="badge badge-primary">{{form.jabatan}}</span>
            </div>
            <div style="margin-top:20px">
              <vs-table striped>
                <template #thead>
                  <vs-tr>
                    <vs-th class="datadiri">
                      Data Diri
                    </vs-th>
                    <vs-th></vs-th>
                  </vs-tr>
                </template>
                <template #tbody>
                  <vs-tr>
                    <vs-td><b>Email</b></vs-td>
                    <vs-td>{{ form.email }}</vs-td>
                  </vs-tr>
                  <vs-tr>
                    <vs-td><b>No HP</b></vs-td>
                    <vs-td>{{ form.no_hp }}</vs-td>
                  </vs-tr>
                  <!-- <vs-tr>
                    <vs-td><b>Pemda Prov / Kab / Kota</b></vs-td>
                    <vs-td>{{ form.goverment ? form.goverment.nama : '-' }}</vs-td>
                  </vs-tr>
                  <vs-tr>
                    <vs-td><b>Unit Kerja</b></vs-td>
                    <vs-td>{{ form.unit_kerja}}</vs-td>
                  </vs-tr>
                  <vs-tr>
                    <vs-td><b>Organisasi</b></vs-td>
                    <vs-td>{{ form.unit_kerja}}</vs-td>
                  </vs-tr> -->
                </template>
              </vs-table>
            </div>
          </el-card>
        </div>
      </div>
    </div>

    <vs-dialog v-model="tambahDialog" :width="$store.state.drawer.mode === 'mobile' ? '80%' : '60%'">
      <template #header>
        <h1 class="not-margin">
          Ubah Profile
        </h1>
      </template>
      <div class="con-form">
        <vs-row>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="12" style="padding:5px">
            <label>Foto</label>
            <el-upload :action="api_url + '/fake-upload'" :on-change="handleChangeFile" list-type="picture-card" accept="image/*"
            :file-list="files" :limit="1">
            <i class="el-icon-plus"></i>
            </el-upload>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Nama</label>
            <vs-input type="text" v-model="form.nama" placeholder="Nama"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>NIP</label>
            <vs-input type="number" v-model="form.nip" placeholder="NIP"></vs-input>
          </vs-col>
          <!-- <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>No HP</label>
            <vs-input type="number" v-model="form.no_hp" placeholder="No HP"></vs-input>
          </vs-col> -->
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Email</label>
            <vs-input v-model="form.email" placeholder="Email"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Jabatan</label>
            <vs-input type="text" v-model="form.jabatan" placeholder="Jabatan"></vs-input>
          </vs-col>
          <!-- <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Pemda Prov/Kab/Kota</label>
            <vs-select filter placeholder="Pemda Prov/Kab/Kota" v-model="form.id_goverment">
              <vs-option v-for="item in getGoverments.data" :key="item.id" :label="item.nama" :value="item.id">
                {{item.nama}}
              </vs-option>
            </vs-select>
          </vs-col> -->
          <!-- <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Organisasi</label>
            <vs-input type="text" v-model="form.organisasi" placeholder="Organisasi Daerah"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Unit Kerja</label>
            <vs-input type="text" v-model="form.unit_kerja" placeholder="Unit Kerja"></vs-input>
          </vs-col> -->
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Password</label>
            <vs-input type="password" v-model="form.password" placeholder="Password"></vs-input>
          </vs-col>
          <vs-col vs-type="flex" vs-justify="center" vs-align="center" w="6" style="padding:5px">
            <label>Konfirmasi Password</label>
            <vs-input type="password" v-model="form.konfirmasi_password" placeholder="Konfirmasi Password"></vs-input>
          </vs-col>
        </vs-row>
      </div>

      <template #footer>
        <div class="footer-dialog">
          <vs-row>
            <vs-col w="6" style="padding:5px">
              <vs-button block :loading="btnLoader"  @click="confirmation()">Simpan</vs-button>
            </vs-col>
            <vs-col w="6" style="padding:5px">
              <vs-button block border @click="tambahDialog = false;">Batal</vs-button>
            </vs-col>
          </vs-row>
          <div>&nbsp;</div>
        </div>
      </template>
    </vs-dialog>
  </div>
</template>

<script>
  import {
    mapMutations,
    mapGetters
  } from 'vuex';

  import {
    config
  } from '../global.config'

  export default {
    layout: 'admin',
    data() {
      return {
        api_url: config.baseApiUrl,
        tambahDialog: false,
        btnLoader: false,
        files: [],
        form: {
          email: "",
          // id_goverment: null,
          jabatan: "",
          nama: "",
          nip: "",
          // no_hp: "",
          // organisasi: "",
          // unit_kerja: "",
          password: '',
          konfirmasi_password: '',
          foto_url: null
        }
      }
    },
    mounted() {
      this.form = JSON.parse(JSON.stringify(this.$auth.user))
      if(this.form.foto_url){
        this.files.push({
          name: '',
          url: this.form.foto_url
        })
      }
      this.form.password =  ''
      this.form.konfirmasi_password =  ''
      this.$store.dispatch('goverment/getAll', {
        showall: 0
      });
      console.log(this.form)
    },
    methods: {
      onSubmit() {
        console.log('submit!');
      },
      handleChangeFile(file, fileList) {
        console.log(file)
        this.form.foto = file.raw
      },
      handleChangeSelect(data) {
        this.$store.dispatch('goverment/getAll', {
          search: data,
          showall: 0
        });
      },
      confirmation() {
        if (this.form.konfirmasi_password == this.form.password) {
          this.onSubmit()
        } else {
          this.$notify.error({
            title: 'Konfirmasi Password',
            message: `Password Tidak Sama`
          })
        }
      },
      onSubmit(type = 'store') {
        this.btnLoader = true
        let url = `/user/${this.form.id}/profile`;
        let formData = new FormData;
        formData.append('nama', this.form.nama)
        formData.append('email', this.form.email)
        formData.append('jabatan', this.form.jabatan)
        // formData.append('id_goverment', this.form.id_goverment)
        // formData.append('organisasi', this.form.organisasi)
        // formData.append('unit_kerja', this.form.unit_kerja)
        formData.append('nip', this.form.nip)
        // formData.append('no_hp', this.form.no_hp)
        if(this.form.password !== ''){
          formData.append('password', this.form.password)
        }
        if (this.form.foto) {
          formData.append("foto", this.form.foto)
        }
        this.$axios.post(url, formData).then(resp => {
          if (resp.data.success) {
            this.$notify.success({
              title: 'Success',
              message: `Berhasil Mengubah Profile`
            })
            this.$auth.setUser(resp.data.data)
            this.tambahDialog = false
            this.$store.dispatch('user/getAll', {});
          }
        }).finally(() => {
          this.btnLoader = false
        }).catch(err => {
          let error = err.response.data.data
          if (error) {
            this.showErrorField(error)
          } else {
            this.$notify.error({
              title: 'Error',
              message: err.response.data.message
            })
          }
        })
      },
    },
    computed: {
      ...mapGetters("goverment", [
        'getGoverments',
      ])
    },
  }

</script>

<style lang="scss" scoped>
  .heading {
    color: white;
    font-size: 25px;
    font-weight: bold;
  }

  .datadiri {
    width: 60px !important;
  }

</style>
