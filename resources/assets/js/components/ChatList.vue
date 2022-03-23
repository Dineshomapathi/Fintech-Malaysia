<template>
    <div class="leaderboard">
        <div id="h-scrollbar2">
            <div class="agendaTitle">
                <h1 class="title" style="text-transform:capitalize;">Networking Lounge</h1>
                <ul class="nav justify-content-center" v-if="tabList">
                    <li class="nav-item" v-for="(item, index) in tabList" @click.prevent="selectedTab = item.slug">
                        <a data-toggle="tab" :href="'#menu'+index" class="nav-link" :class="selectedTab == item.slug ? 'active' : ''" >
                            <p v-if="item.slug == 'suggestion' " class="text-uppercase pDate"><i class="fas fa-star"></i> {{item.slug}}</p>
                            <p v-else class="text-uppercase pDate">{{item.slug}}</p>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div :id="'menu'+index" :class="selectedTab == item.slug ? 'tab-pane fade show text-center h-100 active' : 'tab-pane fade text-center h-100'" v-for="(item, index) in tabList">
                    <div class="agendaContent" v-if="selectedTab == 'suggestions'">
                      <div class="my-3 w-100">
                        
                      
                        <header style="display:none">                                      
                          <h1 class="leaderboard__title"><span class="leaderboard__input--bottom" style="font-family: 'DIN Pro', sans-serif !important;padding-top: 10px;"><input id="inputfield" style="font-family: 'DIN Pro', sans-serif !important;" type="text" placeholder="Type a name, company or designation" v-model="NameSearchString3" /></span></h1>
                        </header>
                        
                          <div class="row" v-if="user3.length != 0">
                              <div id="column" v-for="user3 in filtereduser3" v-bind:key="user3.id">
                                  <figure class="snip1336">
                                    <figcaption>
                                      <h2 style="text-transform:capitalize;"><img v-if="test(user3.updated_at)" src="/image/green.png" id="imgback"><img v-else src="/image/gray.png" id="imgback">{{ user3.name }}<span>{{ user3.company }}</span></h2>
                                      <a @click="redirectss(user3.booth)" class="info">Message</a>
                                    </figcaption>
                                  </figure>
                              </div>
                          </div>

                          <div class="row" v-else>
                              <div id="column" style="border-bottom: none !important; text-align-last: center;">
                                  <figure class="snip1336">
                                    <figcaption>
                                      <h2>No Match Making Available</h2>
                                    </figcaption>
                                  </figure>
                              </div>
                          </div>
                        
                      </div>

                    </div>
                </div>
                <div class="agendaContent" v-if="selectedTab == 'all exhibitors'">
                    <div class="my-3 w-100">

                        <header>                                      
                          <h1 class="leaderboard__title"><span class="leaderboard__input--bottom" style="font-family: 'DIN Pro', sans-serif !important;padding-top: 10px;"><input id="inputfield" style="font-family: 'DIN Pro', sans-serif !important;" type="text" placeholder="Type a name, company or designation" v-model="NameSearchString2" /></span></h1>
                        </header>
                        
                          <div class="row">
                              <div id="column" v-for="user2 in actualFiltereduser2" v-bind:key="user2.id">
                                  <figure class="snip1336">
                                    <figcaption>
                                      <h2 style="text-transform:capitalize;"><img v-if="test(user2.updated_at)" src="/image/green.png" id="imgback"><img v-else src="/image/gray.png" id="imgback">{{ user2.name }}<span>{{ user2.company }}</span></h2>
                                      <a @click="redirects(user2.booth)" class="info">Message</a>
                                    </figcaption>
                                  </figure>
                              </div>
                          </div>

                    </div>
                </div>
                <div class="agendaContent" v-if="selectedTab == 'all participants'">
                    <div class="my-3 w-100">
                          <header>                                      
                            <h1 class="leaderboard__title"><span class="leaderboard__input--bottom" style="font-family: 'DIN Pro', sans-serif !important;padding-top: 10px;"><input id="inputfield" style="font-family: 'DIN Pro', sans-serif !important;" type="text" placeholder="Type a name, company or designation" v-model="NameSearchString" /></span></h1>
                          </header>  
                        
                          <div class="row">
                              <div id="column" v-for="user in actualFiltereduser" v-bind:key="user.id">
                                  <figure class="snip1336">
                                    <figcaption>
                                      <h2 style="text-transform:capitalize;"><img v-if="test(user.updated_at)" src="/image/green.png" id="imgback"><img v-else src="/image/gray.png" id="imgback">{{ user.name }}<span>{{ user.position }}</span><span>{{ user.company }}</span></h2>
                                      <a @click="redirect(user.booth)" class="info">Message</a>
                                    </figcaption>
                                  </figure>
                              </div>
                          </div>
                        <!-- <infinite-loading @distance="1" @infinite="infiniteHandler"></infinite-loading> -->
                    </div>
                </div>
            </div>
</div>
    </div>

</template>

<script>
import {mapActions, mapMutations, mapState} from "vuex";
import moment from 'moment';

export default {
    props: {
        users: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            isLoading: true,
            tabList: ['suggestions', 'all exhibitors', 'all participants'],

            tabList: [
                {'slug':'suggestions', 'font':'fas fa-user'},
                {'slug':'all exhibitors', 'font':'fas fa-briefcase'},
                {'slug':'all participants', 'font':'fas fa-tasks'}
            ],

            selectedTab: 'all exhibitors',

            NameSearchString: "",
            NameSearchString2: "",
            NameSearchString3: "",
            userFeed: null,
            userFeed2: null,
            userFeed3: null,

            chunkNumber: 0,
            chunkFiltereduser: [],
            actualFiltereduser: [],

            chunkNumber2: 0,
            chunkFiltereduser2: [],
            actualFiltereduser2: [],
        }
    },
    computed: {
        filtereduser3: function () {

            var user3 = this.userFeed3;
            var NameSearchString3 = this.NameSearchString3;

            var searchString = NameSearchString3.trim().toLowerCase();


            if(!NameSearchString3){
                return user3;
            }

            user3 = user3.filter(function(item){
                if(item.name.toLowerCase().indexOf(searchString) !== -1 || item.company.toLowerCase().indexOf(searchString) !== -1 || item.position.toLowerCase().indexOf(searchString) !== -1){
                    return item;
                }
            })
            
            return user3;
        },
    },
    mounted() {
        axios.get('/listuser')
        .then(response => {
            this.userFeed = response.data;
            this.user = response.data;
            this.filtereduser();
            // console.log(response.data);
        }).catch(error => console.log(error))

        axios.get('/listexhibitor')
        .then(response => {
            this.userFeed2 = response.data;
            this.user2 = response.data;
            this.filtereduser2();
            // console.log(response.data.length);
        }).catch(error => console.log(error))

        axios.get('/listsuggestion')
        .then(response => {
            this.userFeed3 = response.data;
            this.user3 = response.data;
        }).catch(error => console.log(error))
        
        
        var that = this;
        $("#h-scrollbar2").on('scroll', function () {
            if (Math.round($(this).scrollTop() + $(this).innerHeight()) >= $(this)[0].scrollHeight) {
              if(that.selectedTab == "all participants"){
                if(that.chunkNumber < that.chunkFiltereduser.length){
                  that.actualFiltereduser = _.union(that.actualFiltereduser, that.chunkFiltereduser[that.chunkNumber]);
                  that.chunkNumber++;
                }
              }else if(that.selectedTab == "all exhibitors"){
                if(that.chunkNumber2 < that.chunkFiltereduser2.length){
                      that.actualFiltereduser2 = _.union(that.actualFiltereduser2, that.chunkFiltereduser2[that.chunkNumber2]);
                      that.chunkNumber2++;
                    }
                }
              }
        });
    },
    methods: {
      filtereduser(){
            var user = this.userFeed;
            var NameSearchString = this.NameSearchString;

            var searchString = NameSearchString.trim().toLowerCase();


            if(NameSearchString){
                user = user.filter(function(item){
                if(item.name.toLowerCase().indexOf(searchString) !== -1){
                    return item;
                }
              })
            }

            this.chunkFiltereduser = _.chunk(user, 25);
            if(this.chunkFiltereduser.length > 0){
              this.actualFiltereduser = _.union(this.actualFiltereduser, this.chunkFiltereduser[this.chunkNumber]);
              this.chunkNumber++;
            }

            return user;
      },
      filtereduser2() {

            var user2 = this.userFeed2;
            var NameSearchString2 = this.NameSearchString2;

            var searchString = NameSearchString2.trim().toLowerCase();


            if(NameSearchString2){
                user2 = user2.filter(function(item){
                if(item.name.toLowerCase().indexOf(searchString) !== -1 || item.company.toLowerCase().indexOf(searchString) !== -1){
                    return item;
                }
              })
            }

            this.chunkFiltereduser2 = _.chunk(user2, 25);
            if(this.chunkFiltereduser2.length > 0){
              this.actualFiltereduser2 = _.union(this.actualFiltereduser2, this.chunkFiltereduser2[this.chunkNumber2]);
              this.chunkNumber2++;
            }

            return user2;
      },
      redirect(useremail) {
          window.location.href = '/login?user='+this.users.loginotp+'&booth='+useremail
      },
      redirects(useremail2) {
          window.location.href = '/login?user='+this.users.loginotp+'&booth='+useremail2
      },
      redirectss(useremail3) {
          window.location.href = '/login?user='+this.users.loginotp+'&booth='+useremail3
      },
      test(item){
        var now = moment().format();
        var data = moment(item).format();
        return moment(now).diff(moment(data), 'minutes') < 30;
      }
    },
    watch: {
        'selectedTab'(){
            if(this.selectedTab == 'all exhibitors'){
                this.NameSearchString2 = "";
                // if(this.chunkNumber2 != 0){
                //   this.chunkNumber2 = 0;
                //   this.actualFiltereduser2 = [];
                // }
            }else if(this.selectedTab == 'all participants'){
                this.NameSearchString = "";
                // if(this.chunkNumber != 0){
                //   this.chunkNumber = 0;
                //   this.actualFiltereduser = [];
                // }
            }else if(this.selectedTab == 'suggestions'){
      
            }
        },
        'NameSearchString'(){
          this.chunkNumber = 0;
          this.actualFiltereduser = [];
          this.filtereduser();
        },
        'NameSearchString2'(){
          this.chunkNumber2 = 0;
          this.actualFiltereduser2 = [];
          this.filtereduser2();
        }
    }
}
</script>

<style lang="scss" scoped>
.title{
    color: #002199;
    font-weight: 600;
    margin: auto;
    margin-bottom: 10px;
    margin-top: 10px;
    text-align:center;
    text-decoration: underline;
    text-decoration-color: #32D791;
    text-underline-offset: 8px;
    text-decoration-thickness: 5px;
}

.agendaTitle{
    .nav-item{
        margin-top:10px;
        margin-bottom:10px;
    }
    .nav-link {
        color: #0024A1;
        text-align: center;
        // border-radius: 20px;
        // padding: 10px 30px;
        border: 1px solid #0024A1;
        min-width: 100px;
    }
    .nav-link.active {
        background-color: #0024A1;
        color: #ffffff;
    }

    .pDate{
        margin-bottom:0px;
        font-weight:600;
    }
}

.agendaTitle ul li:first-child a {
    border-radius: 20px 0px 0px 20px !important;
    margin-left:10px;
}

.agendaTitle ul li:last-child a {
    border-radius: 0px 20px 20px 0px !important;
    margin-right: 10px;
}

.agendaContent{
    background: #FFFFFF;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    display: flex;
    align-items: baseline;
    margin-top: 30px;
    justify-content: center;
    padding: 0px 20px;
    text-align:left;
}

@media only screen and (max-width: 991px) {
    .agendaContent {
        padding: 0px 10px;
    }
}

@import url('https://fonts.cdnfonts.com/css/din-pro');

/* Extra small devices (phones, 600px and down) */
/* Small devices (portrait tablets and large phones, 600px and lower) */
@media only screen and (max-width: 600px) {

.agendaTitle{
    .nav-item{
        margin-top:10px;
        margin-bottom:10px;
    }
    .nav-link {
        color: #0024A1;
        text-align: center;
        // border-radius: 20px;
        // padding: 10px 30px;
        border: 1px solid #0024A1;
        max-width: 100px !important;
    }
    .nav-link.active {
        background-color: #0024A1;
        color: #ffffff;
    }

    .pDate{
        margin-bottom:0px;
        font-weight:600;
        font-size: 8px !important;
    }
}


#inputfield {
margin-top: 10px;
border: none;
// background: transparent;
color: #000;
padding: 3px 10px;
font-size: 18px;
// height: 30px;
border-radius: 5px;
width: calc(100% - 15px);
border: 2px solid #00249D;
}
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
color: #000;
opacity: 1; /* Firefox */
}
.leaderboard {
//   max-width: 490px;
width: 100%;
border-radius: 12px;
}
.leaderboard header {
--start: 15%;
height: 80px;
// background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(206,217,163, 0.33) 10%, rgba(206,217,163, 0.33) 17%), linear-gradient(to right, #becc85, #32D38D);
color: #fff;
position: relative;
border-radius: 12px 12px 0 0;
overflow: hidden;
}
.leaderboard header .leaderboard__title {
position: absolute;
z-index: 2;
top: 40%;
width: calc(100% - 15px);
// right: calc(var(--start) * .75);
transform: translateY(-50%);
// text-transform: uppercase;
margin: 0px 15px;
}
.leaderboard header .leaderboard__title span {
display: block;
}
.leaderboard header .leaderboard__title--top {
// font-size: 24px;
font-weight: 700;
// letter-spacing: 6.5px;
color:#00249D;
text-decoration: underline;
text-decoration-color: #32D38D;
text-underline-offset: 8px;
}
.leaderboard header .leaderboard__title--bottom {
font-size: 13px;
font-weight: 500;
letter-spacing: 3.55px;
opacity: 0.65;
transform: translateY(-2px);
}
.leaderboard header .leaderboard__input--bottom {
font-size: 13px;
font-weight: 500;
letter-spacing: 3.55px;
opacity: 0.65;
transform: translateY(-2px);
}
.leaderboard header .leaderboard__icon {
fill: #fff;
opacity: 0.35;
width: 50px;
position: absolute;
top: 50%;
left: var(--start);
transform: translate(-50%, -50%);
}
.leaderboard {
box-shadow: 0 0 40px -10px rgba(0, 0, 0, 0.4);
}

// @mixin flex-grid-items($cols) {
//   display: inline-block;
//   width: 100%;
//   flex-wrap: wrap;

//   > * {
//     $item-width: 100% / $cols;
//     width: $item-width;
//     box-sizing: border-box;
//   }
// }

// .flex-cols {
//   @include flex-grid-items(1)
// }

// ul {
//   margin: 0;
//   padding: 0;
//   list-style-type: none;
//   overflow-y: scroll;
//   height: calc(100% - 130px);
//   // height: fit-content;

//   li {
//     // border: 1px solid yellowgreen;
//     // padding: 30px;
//     // height: fit-content;
//   }

// }

.snip1336 {
      font-family: 'DIN Pro', sans-serif !important;
  position: relative;
  overflow: hidden;
  // margin: 10px;
  min-width: 230px;
  /* max-width: 315px; */
  /* width: 100%; */
  color: #141414;
  text-align: left;
  line-height: 1.4em;
  background-color: #fff;
  // border: 1px solid #32D38D;
  //   border-right: 1px solid #32D38D;
  // border-bottom: 1px solid #32D38D;
  margin: 0px;
}

.snip1336 * {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transition: all 0.25s ease;
  transition: all 0.25s ease;
}
.snip1336 figcaption {
  width: 100%;
  background-color: #fff;
  padding: 10px;
  position: relative;
}
.snip1336 figcaption:before {
  position: absolute;
  content: '';
  bottom: 100%;
  left: 0;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 55px 0 0 400px;
  // border-color: transparent transparent transparent #141414;
}
.snip1336 figcaption a {
  padding: 5px;
  background-color: #32D38D;
  border: 1px solid #32D38D;
  color: #fff;
  font-size: 0.9em;
  // text-transform: uppercase;
  /* margin: 10px 0; */
  display: inline-block;
  // opacity: 0.65;
  width: 150px;
  margin-left: 0px !important;
  border-radius: 10px;
  text-align: center;
  text-decoration: none;
  font-weight: 600;
  letter-spacing: 1px;
  float: right;
}
.snip1336 figcaption a:hover {
  // opacity: 1;
  cursor: pointer;
}
.snip1336 h2 {
  margin: 0 0 5px;
  font-weight: 300;
  font-size: 0.8rem !important;
  display: inline-block;
}
.snip1336 h2 span {
  display: block;
  font-size: 0.6rem !important;
  color: #000;
  margin-left: 25px;
    margin-top: 5px;
}

#column{
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
    border-bottom: 1px solid;
}

}
    
/* Medium devices (landscape tablets, 768px and lower) */
@media only screen and (max-width: 768px) {
#inputfield {
margin-top: 10px;
border: none;
// background: transparent;
color: #000;
padding: 3px 10px;
font-size: 18px;
// height: 30px;
border-radius: 5px;
width: calc(100% - 15px);
border: 2px solid #00249D;
}
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
color: #000;
opacity: 1; /* Firefox */
}
.leaderboard {
//   max-width: 490px;
width: 100%;
border-radius: 12px;
}
.leaderboard header {
--start: 15%;
height: 80px;
// background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(206,217,163, 0.33) 10%, rgba(206,217,163, 0.33) 17%), linear-gradient(to right, #becc85, #32D38D);
color: #fff;
position: relative;
border-radius: 12px 12px 0 0;
overflow: hidden;
}
.leaderboard header .leaderboard__title {
position: absolute;
z-index: 2;
top: 40%;
width: calc(100% - 15px);
// right: calc(var(--start) * .75);
transform: translateY(-50%);
// text-transform: uppercase;
margin: 0px 15px;
}
.leaderboard header .leaderboard__title span {
display: block;
}
.leaderboard header .leaderboard__title--top {
// font-size: 24px;
font-weight: 700;
// letter-spacing: 6.5px;
color:#00249D;
text-decoration: underline;
text-decoration-color: #32D38D;
text-underline-offset: 8px;
}
.leaderboard header .leaderboard__title--bottom {
font-size: 13px;
font-weight: 500;
letter-spacing: 3.55px;
opacity: 0.65;
transform: translateY(-2px);
}
.leaderboard header .leaderboard__input--bottom {
font-size: 13px;
font-weight: 500;
letter-spacing: 3.55px;
opacity: 0.65;
transform: translateY(-2px);
}
.leaderboard header .leaderboard__icon {
fill: #fff;
opacity: 0.35;
width: 50px;
position: absolute;
top: 50%;
left: var(--start);
transform: translate(-50%, -50%);
}
.leaderboard {
box-shadow: 0 0 40px -10px rgba(0, 0, 0, 0.4);
}

// @mixin flex-grid-items($cols) {
//   display: inline-block;
//   width: 100%;
//   flex-wrap: wrap;

//   > * {
//     $item-width: 100% / $cols;
//     width: $item-width;
//     box-sizing: border-box;
//   }
// }

// .flex-cols {
//   @include flex-grid-items(1)
// }

// ul {
//   margin: 0;
//   padding: 0;
//   list-style-type: none;
//   overflow-y: scroll;
//   height: calc(100% - 130px);
//   // height: fit-content;
//   // border: 1px solid yellowgreen;

//   li {
//     // border: 1px solid yellowgreen;
//     // padding: 30px;
//     // height: fit-content;
//   }

// }


.snip1336 {
      font-family: 'DIN Pro', sans-serif !important;
  position: relative;
  overflow: hidden;
  // margin: 10px;
  min-width: 230px;
  /* max-width: 315px; */
  /* width: 100%; */
  color: #141414;
  text-align: left;
  line-height: 1.4em;
  background-color: #fff;
  // border: 1px solid #32D38D;
  //   border-right: 1px solid #32D38D;
  // border-bottom: 1px solid #32D38D;
  margin: 0px;
}
.snip1336 * {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transition: all 0.25s ease;
  transition: all 0.25s ease;
}
.snip1336 figcaption {
  width: 100%;
  background-color: #fff;
  padding: 10px;
  position: relative;
}
.snip1336 figcaption:before {
  position: absolute;
  content: '';
  bottom: 100%;
  left: 0;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 55px 0 0 400px;
  // border-color: transparent transparent transparent #141414;
}
.snip1336 figcaption a {
  padding: 5px;
    background-color: #32D38D;
  border: 1px solid #32D38D;
  color: #fff;
  font-size: 0.9em;
  // text-transform: uppercase;
  /* margin: 10px 0; */
  display: inline-block;
  // opacity: 0.65;
  width: 150px;
  margin-left: 25px;
  border-radius: 10px;
  text-align: center;
  text-decoration: none;
  font-weight: 600;
  letter-spacing: 1px;
  float: right;
}
.snip1336 figcaption a:hover {
  // opacity: 1;
  cursor: pointer;
}
.snip1336 h2 {
  margin: 0 0 5px;
  font-weight: 300;
  font-size: 1.2rem;
  display: inline-block;
}
.snip1336 h2 span {
  display: block;
  font-size: 0.8rem;
  color: #000;
  margin-left: 25px;
    margin-top: 5px;
}

#column{
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
    border-bottom: 1px solid;
}

}
    
/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
#inputfield {
margin-top: 10px;
border: none;
// background: transparent;
color: #000;
padding: 3px 10px;
font-size: 18px;
// height: 30px;
border-radius: 5px;
width: calc(100% - 15px);
border: 2px solid #00249D;
}
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
color: #000;
opacity: 1; /* Firefox */
}
.leaderboard {
//   max-width: 490px;
width: 100%;
border-radius: 12px;
}
.leaderboard header {
--start: 15%;
height: 80px;
// background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(206,217,163, 0.33) 10%, rgba(206,217,163, 0.33) 17%), linear-gradient(to right, #becc85, #32D38D);
position: relative;
border-radius: 12px 12px 0 0;
overflow: hidden;
color: #fff;
}
.leaderboard header .leaderboard__title {
position: absolute;
z-index: 2;
top: 40%;
width: calc(100% - 15px);
// right: calc(var(--start) * .75);
transform: translateY(-50%);
// text-transform: uppercase;
margin: 0px 15px;
}
.leaderboard header .leaderboard__title span {
display: block;
}
.leaderboard header .leaderboard__title--top {
// font-size: 24px;
font-weight: 700;
// letter-spacing: 6.5px;
color:#00249D;
text-decoration: underline;
text-decoration-color: #32D38D;
text-underline-offset: 8px;
}
.leaderboard header .leaderboard__title--bottom {
font-size: 13px;
font-weight: 500;
letter-spacing: 3.55px;
opacity: 0.65;
transform: translateY(-2px);
}
.leaderboard header .leaderboard__input--bottom {
font-size: 13px;
font-weight: 500;
letter-spacing: 3.55px;
opacity: 0.65;
transform: translateY(-2px);
}
.leaderboard header .leaderboard__icon {
fill: #fff;
opacity: 0.35;
width: 50px;
position: absolute;
top: 50%;
left: var(--start);
transform: translate(-50%, -50%);
}
.leaderboard {
box-shadow: 0 0 40px -10px rgba(0, 0, 0, 0.4);
}

// @mixin flex-grid-items($cols) {
//   display: inline-flex;
//   width: 100%;
//   flex-wrap: wrap;

//   > * {
//     $item-width: 100% / $cols;
//     width: $item-width;
//     box-sizing: border-box;
//   }
// }

// .flex-cols {
//   @include flex-grid-items(2)
// }

// ul {
//   margin: 0;
//   padding: 0;
//   list-style-type: none;
//   overflow-y: scroll;
//   height: calc(100% - 130px);
//   // height: fit-content;

//   li {
//     // border: 1px solid yellowgreen;
//     // padding: 30px;
//   }

// }

.snip1336 {
      font-family: 'DIN Pro', sans-serif !important;
  position: relative;
  overflow: hidden;
  // margin: 10px;
  min-width: 230px;
  /* max-width: 315px; */
  /* width: 100%; */
  color: #141414;
  text-align: left;
  line-height: 1.4em;
  background-color: #fff;
  // border: 1px solid #32D38D;
  // border-right: 1px solid #32D38D;
  // border-bottom: 1px solid #32D38D;
  margin: 0px;
}
.snip1336 * {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transition: all 0.25s ease;
  transition: all 0.25s ease;
}
.snip1336 figcaption {
  width: 100%;
  background-color: #fff;
  padding: 10px;
  position: relative;
}
.snip1336 figcaption:before {
  position: absolute;
  content: '';
  bottom: 100%;
  left: 0;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 55px 0 0 400px;
  // border-color: transparent transparent transparent #141414;
}
.snip1336 figcaption a {
  padding: 5px;
  background-color: #32D38D;
  border: 1px solid #32D38D;
  color: #fff;
  font-size: 0.9em;
  // text-transform: uppercase;
  /* margin: 10px 0; */
  display: inline-block;
  // opacity: 0.65;
  width: 150px;
  margin-left: 25px;
  border-radius: 10px;
  text-align: center;
  text-decoration: none;
  font-weight: 600;
  letter-spacing: 1px;
  float: right;
}
.snip1336 figcaption a:hover {
  // opacity: 1;
  cursor: pointer;
}
.snip1336 h2 {
  margin: 0 0 5px;
  font-weight: 300;
  font-size: 1.2rem;
  display: inline-block;
}
.snip1336 h2 span {
  display: block;
  font-size: 0.8rem;
  color: #000;
  margin-left: 25px;
    margin-top: 5px;
}

#column{
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
    border-bottom: 1px solid;
}

}
    
/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
#inputfield {
    margin-top: 10px;
    border: none;
    // background: transparent;
    color: #000;
    padding: 3px 10px;
    font-size: 18px;
    // height: 30px;
    border-radius: 5px;
    width: calc(100% - 15px);
    border: 2px solid #00249D;
}

::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #000;
  opacity: 1; /* Firefox */
}   
.leaderboard {
//   max-width: 490px;
  width: 100%;
  border-radius: 12px;
}
.leaderboard header {
  --start: 15%;
  height: 80px;
  // background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(206,217,163, 0.33) 10%, rgba(206,217,163, 0.33) 17%), linear-gradient(to right, #becc85, #32D38D);
  color: #fff;
  position: relative;
  border-radius: 12px 12px 0 0;
  overflow: hidden;
}
.leaderboard header .leaderboard__title {
  position: absolute;
  z-index: 2;
  top: 40%;
  width: calc(100% - 15px);
  // right: calc(var(--start) * .75);
  transform: translateY(-50%);
  // text-transform: uppercase;
  margin: 0px 15px;
}
.leaderboard header .leaderboard__title span {
  display: block;
}
.leaderboard header .leaderboard__title--top {
  // font-size: 24px;
  font-weight: 700;
  // letter-spacing: 6.5px;
  color:#00249D;
  text-decoration: underline;
  text-decoration-color: #32D38D;
  text-underline-offset: 8px;
}
.leaderboard header .leaderboard__title--bottom {
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 3.55px;
  opacity: 0.65;
  transform: translateY(-2px);
}
.leaderboard header .leaderboard__input--bottom {
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 3.55px;
  opacity: 0.65;
  transform: translateY(-2px);
}
.leaderboard header .leaderboard__icon {
  fill: #fff;
  opacity: 0.35;
  width: 50px;
  position: absolute;
  top: 50%;
  left: var(--start);
  transform: translate(-50%, -50%);
}
.leaderboard {
  box-shadow: 0 0 40px -10px rgba(0, 0, 0, 0.4);
}

// @mixin flex-grid-items($cols) {
//   display: inline-flex;
//   width: 100%;
//   flex-wrap: wrap;

//   > * {
//     $item-width: 100% / $cols;
//     width: $item-width;
//     box-sizing: border-box;
//   }
// }

// .flex-cols {
//   @include flex-grid-items(2)
// }

// ul {
//   margin: 0;
//   padding: 0;
//   list-style-type: none;
//   overflow-y: scroll;
//   height: calc(100% - 130px);
//   // height: fit-content;

//   li {
//     // border: 1px solid yellowgreen;
//     // padding: 30px;
//   }

// }

.snip1336 {
      font-family: 'DIN Pro', sans-serif !important;
  position: relative;
  overflow: hidden;
  // margin: 10px;
  min-width: 230px;
  /* max-width: 315px; */
  /* width: 100%; */
  color: #141414;
  text-align: left;
  line-height: 1.4em;
  background-color: #fff;
  // border: 1px solid #32D38D;
  //   border-right: 1px solid #32D38D;
  // border-bottom: 1px solid #32D38D;
  margin: 0px;
}
.snip1336 * {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transition: all 0.25s ease;
  transition: all 0.25s ease;
}
.snip1336 figcaption {
  width: 100%;
  background-color: #fff;
  padding: 10px;
  position: relative;
}
.snip1336 figcaption:before {
  position: absolute;
  content: '';
  bottom: 100%;
  left: 0;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 55px 0 0 400px;
  // border-color: transparent transparent transparent #141414;
}
.snip1336 figcaption a {
  padding: 5px;
  background-color: #32D38D;
  border: 1px solid #32D38D;
  color: #fff;
  font-size: 0.9em;
  // text-transform: uppercase;
  /* margin: 10px 0; */
  display: inline-block;
  // opacity: 0.65;
  width: 150px;
  margin-left: 25px;
  border-radius: 10px;
  text-align: center;
  text-decoration: none;
  font-weight: 600;
  letter-spacing: 1px;
  float: right;
}
.snip1336 figcaption a:hover {
  // opacity: 1;
  cursor: pointer;
}
.snip1336 h2 {
  margin: 0 0 5px;
  font-weight: 300;
  font-size: 1.2rem;
  display: inline-block;
}
.snip1336 h2 span {
  display: block;
  font-size: 0.8rem;
  color: #000;
  margin-left: 25px;
    margin-top: 5px;
}

#column{
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
    border-bottom: 1px solid;
}

}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {

#inputfield {
margin-top: 10px;
border: none;
// background: transparent;
color: #000;
padding: 3px 10px;
font-size: 18px;
// height: 30px;
border-radius: 5px;
width: calc(100% - 15px);
border: 2px solid #00249D;
}
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
color: #000;
opacity: 1; /* Firefox */
}
.leaderboard {
//   max-width: 490px;
width: 100%;
border-radius: 12px;
}
.leaderboard header {
--start: 15%;
height: 80px;
// background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(206,217,163, 0.33) 10%, rgba(206,217,163, 0.33) 17%), linear-gradient(to right, #becc85, #32D38D);
color: #fff;
position: relative;
border-radius: 12px 12px 0 0;
overflow: hidden;
}
.leaderboard header .leaderboard__title {
position: absolute;
z-index: 2;
top: 40%;
width: calc(100% - 15px);
// right: calc(var(--start) * .75);
transform: translateY(-50%);
// text-transform: uppercase;
margin: 0px 15px;
}
.leaderboard header .leaderboard__title span {
display: block;
}
.leaderboard header .leaderboard__title--top {
// font-size: 24px;
font-weight: 700;
// letter-spacing: 6.5px;
color:#00249D;
text-decoration: underline;
text-decoration-color: #32D38D;
text-underline-offset: 8px;
}
.leaderboard header .leaderboard__title--bottom {
font-size: 13px;
font-weight: 500;
letter-spacing: 3.55px;
opacity: 0.65;
transform: translateY(-2px);
}
.leaderboard header .leaderboard__input--bottom {
font-size: 13px;
font-weight: 500;
letter-spacing: 3.55px;
opacity: 0.65;
transform: translateY(-2px);
}
.leaderboard header .leaderboard__icon {
fill: #fff;
opacity: 0.35;
width: 50px;
position: absolute;
top: 50%;
left: var(--start);
transform: translate(-50%, -50%);
}
.leaderboard {
box-shadow: 0 0 40px -10px rgba(0, 0, 0, 0.4);
}

// @mixin flex-grid-items($cols) {
//   display: inline-flex;
//   width: 100%;
//   flex-wrap: wrap;

//   > * {
//     $item-width: 100% / $cols;
//     width: $item-width;
//     box-sizing: border-box;
//   }
// }

// .flex-cols {
//   @include flex-grid-items(2)
// }

// ul {
//   margin: 0;
//   padding: 0;
//   list-style-type: none;
//   overflow-y: scroll;
//   height: calc(100% - 130px);
//   // height: fit-content;
  
//   li {
//     // border: 1px solid yellowgreen;
//     // padding: 10px;
//   }

// }

#column{
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
    border-bottom: 1px solid;
}

.snip1336 {
      font-family: 'DIN Pro', sans-serif !important;
  position: relative;
  overflow: hidden;
  // margin: 10px;
  min-width: 230px;
  /* max-width: 315px; */
  /* width: 100%; */
  color: #141414;
  text-align: left;
  line-height: 1.4em;
  background-color: #fff;
  // border: 1px solid #32D38D;
  //   border-right: 1px solid #32D38D;
  // border-bottom: 1px solid #32D38D;
  margin: 0px;
}
.snip1336 * {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transition: all 0.25s ease;
  transition: all 0.25s ease;
}
.snip1336 figcaption {
  width: 100%;
  background-color: #fff;
  padding: 10px;
  position: relative;
}
.snip1336 figcaption:before {
  position: absolute;
  content: '';
  bottom: 100%;
  left: 0;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 55px 0 0 400px;
  // border-color: transparent transparent transparent #141414;
}
.snip1336 figcaption a {
  padding: 5px;
  background-color: #32D38D;
  border: 1px solid #32D38D;
  color: #fff;
  font-size: 0.9em;
  // text-transform: uppercase;
  // margin: 10px 0; 
  display: inline-block;
  // opacity: 0.65;
  width: 150px;
  margin-left: 25px;
  border-radius: 10px;
  text-align: center;
  text-decoration: none;
  font-weight: 600;
  letter-spacing: 1px;
  float: right;
}
.snip1336 figcaption a:hover {
  // opacity: 1;
  cursor: pointer;
}
.snip1336 h2 {
  margin: 0 0 5px;
  font-weight: 300;
  font-size: 1.2rem;
  display: inline-block;
}
.snip1336 h2 span {
  display: block;
  font-size: 0.8rem;
  color: #000;
  margin-left: 25px;
  margin-top: 5px;
}

}

#h-scrollbar2{
  height: 100%;
  overflow-x:hidden;
  overflow-y: auto;
  // padding:10px;
}

#h-scrollbar2::-webkit-scrollbar-track{
	-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,.1);
	border-radius:10px;
	background-color:#f5f5f5
}
#h-scrollbar2::-webkit-scrollbar{
	width:5px;
	height:5px;
	background-color:#f5f5f5;
	/* display:none */

}
#h-scrollbar2::-webkit-scrollbar-thumb{
	border-radius:5px;
	background-color:#2e6fc4
}

.row{
  margin-left:0px;
  margin-right:0px;;
}

#imgback{
    width: 20px;
    margin-right: 5px;
}

</style>