<template>
<div class="leaderboard">
  <header>
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve" class="leaderboard__icon"></svg>
    <!-- <h1 class="leaderboard__title"><span class="leaderboard__title--top" style="font-family: 'Source Sans Pro' !important;font-size:2.10rem;">Network Lounge<a href="dashboard" style="float:right;margin-right:15px;font-family: 'Source Sans Pro' !important;"><img style="height:35px;font-family: 'Source Sans Pro' !important;" src="/image/back4.png"></a></span><span class="leaderboard__input--bottom" style="font-family: 'Source Sans Pro' !important;"><input id="inputfield" style="font-family: 'Source Sans Pro' !important;" type="text" placeholder="Type a name or company" v-model="NameSearchString" /></span></h1> -->
    <h1 class="leaderboard__title"><span class="leaderboard__title--top" style="font-family: 'Source Sans Pro' !important;font-size:2.10rem;">Network Lounge</span><span class="leaderboard__input--bottom" style="font-family: 'Source Sans Pro' !important;padding-top: 10px;"><input id="inputfield" style="font-family: 'Source Sans Pro' !important;" type="text" placeholder="Type a name, company or designation" v-model="NameSearchString" /></span></h1>
  </header>
  
  <div id="h-scrollbar">
    <div class="row">
        <div id="column" v-for="user in filtereduser" v-bind:key="user.id">
            <figure class="snip1336">
              <figcaption>
                <h2><img v-if="test(user.updated_at)" src="/image/green.png" id="imgback"><img v-else src="/image/gray.png" id="imgback">{{ user.loginotp }}<span>{{ user.position }}</span><span>{{ user.company }}</span></h2>
                <a @click="redirect(user.email)" class="info">Message</a>
              </figcaption>
            </figure>
        </div>
    </div>
  </div>
  
</div>

</template>

<script>
import moment from 'moment';
export default {
    props: {
        users: {
            type: Object,
            required: true
        }
    },
    data: function() {
        return  {
            NameSearchString: "",
            userFeed: null
        }
    },
    mounted() {
        axios.get('/listuser')
        .then(response => {
             this.userFeed = response.data;
             this.user = response.data;
            // console.log(response.data);
        }).catch(error => console.log(error))
    },
    computed: {
        filtereduser: function () {

            var user = this.userFeed;
            var NameSearchString = this.NameSearchString;

            var searchString = NameSearchString.trim().toLowerCase();


            if(!NameSearchString){
                return user;
            }

            user = user.filter(function(item){
                if(item.loginotp.toLowerCase().indexOf(searchString) !== -1 || item.company.toLowerCase().indexOf(searchString) !== -1 || item.position.toLowerCase().indexOf(searchString) !== -1){
                    return item;
                }
                // console.log(item.company);
            })

            
            return user;
        }
    },
    methods: {
    redirect(useremail) {
        window.location.href = '/login?user='+this.users.loginotp+'&booth='+useremail
    },
    test(item){
      var now = moment().format();
      var data = moment(item).format();
      return moment(now).diff(moment(data), 'minutes') < 30;
    }
  }
}
</script>

<style lang="scss" scoped>

@font-face {
    font-family: 'Source Sans Pro' !important;
    src: url(/font/SourceSansPro-Regular.woff2);
}

/* Extra small devices (phones, 600px and down) */
/* Small devices (portrait tablets and large phones, 600px and lower) */
@media only screen and (max-width: 600px) {
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
height: 130px;
// background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(206,217,163, 0.33) 10%, rgba(206,217,163, 0.33) 17%), linear-gradient(to right, #becc85, #AEC067);
color: #fff;
position: relative;
border-radius: 12px 12px 0 0;
overflow: hidden;
}
.leaderboard header .leaderboard__title {
position: absolute;
z-index: 2;
top: 50%;
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
  font-family: 'Source Sans Pro' !important;
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
  // border: 1px solid #AEC067;
    border-right: 1px solid #32D38D;
  border-bottom: 1px solid #32D38D;
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
  border-color: transparent transparent transparent #141414;
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
}
.snip1336 figcaption a:hover {
  // opacity: 1;
  cursor: pointer;
}
.snip1336 h2 {
  margin: 0 0 5px;
  font-weight: 300;
  font-size: 1.2rem;
}
.snip1336 h2 span {
  display: block;
  font-size: 0.8rem;
  color: #000;
  margin-left: 25px;
}

#column{
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
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
height: 130px;
// background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(206,217,163, 0.33) 10%, rgba(206,217,163, 0.33) 17%), linear-gradient(to right, #becc85, #AEC067);
color: #fff;
position: relative;
border-radius: 12px 12px 0 0;
overflow: hidden;
}
.leaderboard header .leaderboard__title {
position: absolute;
z-index: 2;
top: 50%;
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
  font-family: 'Source Sans Pro' !important;
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
  // border: 1px solid #AEC067;
    border-right: 1px solid #32D38D;
  border-bottom: 1px solid #32D38D;
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
  border-color: transparent transparent transparent #141414;
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
}
.snip1336 figcaption a:hover {
  // opacity: 1;
  cursor: pointer;
}
.snip1336 h2 {
  margin: 0 0 5px;
  font-weight: 300;
  font-size: 1.2rem;
}
.snip1336 h2 span {
  display: block;
  font-size: 0.8rem;
  color: #000;
  margin-left: 25px;
}

#column{
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
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
height: 130px;
// background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(206,217,163, 0.33) 10%, rgba(206,217,163, 0.33) 17%), linear-gradient(to right, #becc85, #AEC067);
position: relative;
border-radius: 12px 12px 0 0;
overflow: hidden;
color: #fff;
}
.leaderboard header .leaderboard__title {
position: absolute;
z-index: 2;
top: 50%;
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
  font-family: 'Source Sans Pro' !important;
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
  // border: 1px solid #AEC067;
  border-right: 1px solid #32D38D;
  border-bottom: 1px solid #32D38D;
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
  border-color: transparent transparent transparent #141414;
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
}
.snip1336 figcaption a:hover {
  // opacity: 1;
  cursor: pointer;
}
.snip1336 h2 {
  margin: 0 0 5px;
  font-weight: 300;
  font-size: 1.2rem;
}
.snip1336 h2 span {
  display: block;
  font-size: 0.8rem;
  color: #000;
  margin-left: 25px;
}

#column{
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
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
  height: 130px;
  // background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(206,217,163, 0.33) 10%, rgba(206,217,163, 0.33) 17%), linear-gradient(to right, #becc85, #AEC067);
  color: #fff;
  position: relative;
  border-radius: 12px 12px 0 0;
  overflow: hidden;
}
.leaderboard header .leaderboard__title {
  position: absolute;
  z-index: 2;
  top: 50%;
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
  font-family: 'Source Sans Pro' !important;
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
  // border: 1px solid #AEC067;
    border-right: 1px solid #32D38D;
  border-bottom: 1px solid #32D38D;
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
  border-color: transparent transparent transparent #141414;
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
}
.snip1336 figcaption a:hover {
  // opacity: 1;
  cursor: pointer;
}
.snip1336 h2 {
  margin: 0 0 5px;
  font-weight: 300;
  font-size: 1.2rem;
}
.snip1336 h2 span {
  display: block;
  font-size: 0.8rem;
  color: #000;
  margin-left: 25px;
}

#column{
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
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
height: 130px;
// background-image: repeating-radial-gradient(circle at var(--start), transparent 0%, transparent 10%, rgba(206,217,163, 0.33) 10%, rgba(206,217,163, 0.33) 17%), linear-gradient(to right, #becc85, #AEC067);
color: #fff;
position: relative;
border-radius: 12px 12px 0 0;
overflow: hidden;
}
.leaderboard header .leaderboard__title {
position: absolute;
z-index: 2;
top: 50%;
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
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}

.snip1336 {
  font-family: 'Source Sans Pro' !important;
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
  // border: 1px solid #AEC067;
    border-right: 1px solid #32D38D;
  border-bottom: 1px solid #32D38D;
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
  border-color: transparent transparent transparent #141414;
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
}
.snip1336 figcaption a:hover {
  // opacity: 1;
  cursor: pointer;
}
.snip1336 h2 {
  margin: 0 0 5px;
  font-weight: 300;
  font-size: 1.2rem;
}
.snip1336 h2 span {
  display: block;
  font-size: 0.8rem;
  color: #000;
  margin-left: 25px;
}

}

#h-scrollbar{
  height: calc(100% - 130px);
  overflow-x:hidden;
  overflow-y: auto;
}

#h-scrollbar::-webkit-scrollbar-track{
	-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,.1);
	border-radius:10px;
	background-color:#f5f5f5
}
#h-scrollbar::-webkit-scrollbar{
	width:5px;
	height:5px;
	background-color:#f5f5f5;
	/* display:none */

}
#h-scrollbar::-webkit-scrollbar-thumb{
	border-radius:5px;
	-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,.3);
	background-color:#AEC067
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