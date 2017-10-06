Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
//Initialize as global component
//Vue.component('date-picker', VueBootstrapDatetimePicker.default);


new Vue({


  el: '#manage-vue',


  data: {
    image:"",
    a: 'male',
    b: 'female',
    infos: [],
    pagination: {

        total: 0, 

        per_page: 2,

        from: 1, 

        to: 0,

        current_page: 1

      },

    offset: 4,

    formErrors:{},

    formErrorsUpdate:{},

    newInfo : {'image':'','name':'','phone':'','email':'','gender':'','dob':'','biography':'','photo':''},

    fillInfo : {'image':'','name':'','phone':'','email':'','gender':'','dob':'','biography':'','photo':'','id':''}

  },


  computed: {

        isActived: function () {

            return this.pagination.current_page;

        },

        pagesNumber: function () {

            if (!this.pagination.to) {

                return [];

            }

            var from = this.pagination.current_page - this.offset;

            if (from < 1) {

                from = 1;

            }

            var to = from + (this.offset * 2);

            if (to >= this.pagination.last_page) {

                to = this.pagination.last_page;

            }

            var pagesArray = [];

            while (from <= to) {

                pagesArray.push(from);

                from++;

            }

            return pagesArray;

        }

    },


  ready : function(){
      console.log("hello to the file vue js ");
  		this.getVueInfos(this.pagination.current_page);
  },


  methods : {
      imageChanged:function(e){
        var fileReader= new FileReader();
        fileReader.readAsDataURL(e.target.files[0]);
        fileReader.onload=(e)=>{
          this.newInfo.image=e.target.result;
          //this.image=e.target.result;
        }  
      },
      imageUpdate:function(e){
        var fileReader= new FileReader();
        fileReader.readAsDataURL(e.target.files[0]);
        fileReader.onload=(e)=>{
          this.fillInfo.image=e.target.result;
          //this.image=e.target.result;
        }  
      },
        getVueInfos: function(page){

          this.$http.get('/vueinfos?page='+page).then((response) => {

            this.$set('infos', response.data.data.data);

            this.$set('pagination', response.data.pagination);

          });

        },


      createInfo: function(){

      var input = this.newInfo;

		  this.$http.post('/vueinfos',input).then((response) => {

	    this.changePage(this.pagination.current_page);

			this.newInfo = {'image':'','name':'','phone':'','email':'','gender':'','dob':'','biography':'','photo':''};

			$("#create-info").modal('hide');

			toastr.success('Info Created Successfully.', 'Success Alert', {timeOut: 5000});

		  }, (response) => {

			this.formErrors = response.data;

	    });

	},


      deleteInfo: function(info){

        this.$http.delete('/vueinfos/'+info.id).then((response) => {

            this.changePage(this.pagination.current_page);

            toastr.success('Info Deleted Successfully.', 'Success Alert', {timeOut: 5000});

        });

      },


      editInfo: function(info){

          this.fillInfo.id = info.id;

          this.fillInfo.name = info.name;

          this.fillInfo.phone = info.phone;

          this.fillInfo.email = info.email;

          this.fillInfo.gender = info.gender;

          this.fillInfo.dob = info.dob;

          this.fillInfo.biography = info.biography;

          this.fillInfo.photo = info.photo;
          

          $("#edit-info").modal('show');

      },


      updateInfo: function(id){

        var input = this.fillInfo;

        this.$http.put('/vueinfos/'+id,input).then((response) => {

            this.changePage(this.pagination.current_page);

            this.fillInfo = {'image':'','name':'','phone':'','email':'','gender':'','dob':'','biography':'','photo':''};

            $("#edit-info").modal('hide');

            toastr.success('Info Updated Successfully.', 'Success Alert', {timeOut: 5000});

          }, (response) => {

              this.formErrorsUpdate = response.data;

          });

      },

      changePage: function (page) {

          this.pagination.current_page = page;

          this.getVueInfos(page);

      }

  }

});