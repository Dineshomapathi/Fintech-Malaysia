<template>
    <div class="conversation" id="maindash" v-if="contact != null">
        <div style="background: #00249D;">
        <img onclick="document.getElementById('maindash').style.display='none';document.getElementById('mode').style.display='block';false;" src="/image/back_fintech.png" id="imgback">
        
        <h1 v-if="contact.name != null && contact.name != 'null'" style="font-family: 'DIN Pro', sans-serif !important;">{{ contact ? contact.name : 'Welcome to your inbox' }}</h1>
        <h1 v-else style="font-family: 'DIN Pro', sans-serif !important;">{{ contact ? contact.loginotp : 'Welcome to your inbox' }}</h1>

        <h5 v-if="contact.project != null && contact.project != 'null' && contact.project != ''">{{ contact.project }}</h5>
        <h5 v-else style="display:none"></h5>
        
        <!-- <h5>{{ contact ? contact.project : '' }}</h5> -->
        </div>
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessageComposer @send="sendMessage"/>
    </div>
    <div class="conversationlanding" v-else>
        <img src="/image/fintech.png" style="width:50%;margin-bottom:30px;">
        <!-- <a href="userlist" id="imgbacka"><img src="/image/infolong.png" id="imgback2"></a> -->
        <h1 style="font-family: 'DIN Pro', sans-serif !important;">Welcome to your inbox</h1>
        <h5 style="font-family: 'DIN Pro', sans-serif !important;">Say hello to fellow exhibitors and other participants.</h5>
    </div>
</template>

<script>
    import MessagesFeed from './MessagesFeed';
    import MessageComposer from './MessageComposer';

    export default {
        props: {
            contact: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            }
        },
        methods: {
            sendMessage(text) {
                if (!this.contact) {
                    return;
                }

                axios.post('/conversation/send', {
                    contact_id: this.contact.id,
                    text: text
                }).then((response) => {
                    this.$emit('new', response.data);
                })
            }
        },
        components: {MessagesFeed, MessageComposer}
    }
</script>

<style lang="scss" scoped>
@import url('https://fonts.cdnfonts.com/css/din-pro');

@media (min-width:320px)  { /* smartphones, iPhone, portrait 480x320 phones */ 
    .conversation {
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        h1 {
            background: #00249D;
            color: #fff;
            font-size: 18px;
            padding: 5px;
            margin: 0;
        }

        h5 {
            background: #00249D;
            color: #fff;
            font-size: 13px;
            padding: 5px;
            margin: 0;
        }
    }
    .conversationlanding {
        // display: none;
        flex: 5;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center; /* vertically aligns items */
        align-items: center; /* horizontally aligns items */
        
        h1 {
            text-align: center;
        }

        h5 {
            text-align: center;
        }
    }
    #imgback{
        float: left;
        width: 40px;
        padding: 5px;
        cursor:pointer;
    }

    #imgback2{
        width:40%;
        cursor:pointer;
        margin-bottom:15px;
    }

    #imgbacka{
        text-align:center;  
    }

}
@media (min-width:481px)  { /* portrait e-readers (Nook/Kindle), smaller tablets @ 600 or @ 640 wide. */ 
    .conversation {
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        h1 {
            background: #00249D;
            color: #fff;
            font-size: 18px;
            padding: 5px;
            margin: 0;
        }

        h5 {
            background: #00249D;
            color: #fff;
            font-size: 13px;
            padding: 5px;
            margin: 0;
        }
    }
    .conversationlanding {
        // display: none;
        flex: 5;
        height: 100%;
        // font-style: oblique;
        display: flex;
        flex-direction: column;
        justify-content: center; /* vertically aligns items */
        align-items: center; /* horizontally aligns items */
    }
    #imgback{
        float: left;
        width: 40px;
        padding: 5px;
        cursor:pointer;
    }

    #imgback2{
        width:40%;
        cursor:pointer;
        margin-bottom:15px;
    }

    #imgbacka{
        text-align:center;  
    }
}
@media (min-width:641px)  { /* portrait tablets, portrait iPad, landscape e-readers, landscape 800x480 or 854x480 phones */ 
    .conversation {
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        h1 {
            background: #00249D;
            color: #fff;
            font-size: 18px;
            padding: 5px;
            margin: 0;
        }

        h5 {
            background: #00249D;
            color: #fff;
            font-size: 13px;
            padding: 5px;
            margin: 0;
        }
    }
    .conversationlanding {
        // display: none;
        flex: 5;
        height: 100%;
        // font-style: oblique;
        display: flex;
        flex-direction: column;
        justify-content: center; /* vertically aligns items */
        align-items: center; /* horizontally aligns items */
    }
    #imgback{
        float: left;
        width: 40px;
        padding: 5px;
        cursor:pointer;
    }

    #imgback2{
        width:40%;
        cursor:pointer;
        margin-bottom:15px;
    }

    #imgbacka{
        text-align:center;  
    }
}
@media (min-width:768px)  { /* tablet, landscape iPad, lo-res laptops ands desktops */
#maindash{
  display: flex !important;  
}
    .conversation {
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        h1 {
            background: #00249D;
            color: #fff;
            font-size: 18px;
            padding: 5px;
            margin: 0;
        }

        h5 {
            background: #00249D;
            color: #fff;
            font-size: 13px;
            padding: 5px;
            margin: 0;
        }
    }
    .conversationlanding {
        flex: 5;
        height: 100%;
        // font-style: oblique;
        display: flex;
        flex-direction: column;
        justify-content: center; /* vertically aligns items */
        align-items: center; /* horizontally aligns items */
    }
    #imgback{
        display: none;
        float: right;
        width: 98px;
        padding: 5px;
        cursor:pointer;
    }

    #imgback2{
        display: none;
        width:40%;
        cursor:pointer;
        margin-bottom:15px;
    }

    #imgbacka{
        display: none;
        text-align:center;  
    }
}
@media (min-width:1025px) { /* big landscape tablets, laptops, and desktops */
#maindash{
  display: flex !important;  
}
    .conversation {
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        h1 {
            background: #00249D;
            color: #fff;
            font-size: 18px;
            padding: 5px;
            margin: 0;
        }

        h5 {
            background: #00249D;
            color: #fff;
            font-size: 13px;
            padding: 5px;
            margin: 0;
        }
    }
    .conversationlanding {
        flex: 5;
        height: 100%;
        // font-style: oblique;
        display: flex;
        flex-direction: column;
        justify-content: center; /* vertically aligns items */
        align-items: center; /* horizontally aligns items */
    }
    #imgback{
        display: none;
        float: right;
        width: 98px;
        padding: 5px;
        cursor:pointer;
    }
    #imgback2{
        display: none;
        width:40%;
        cursor:pointer;
        margin-bottom:15px;
    }

    #imgbacka{
        display: none;
        text-align:center;  
    }
}
@media (min-width:1281px) { /* hi-res laptops and desktops */ 
#maindash{
  display: flex !important;  
}
    .conversation {
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        h1 {
            background: #00249D;
            color: #fff;
            font-size: 18px;
            padding: 5px;
            margin: 0;
        }

        h5 {
            background: #00249D;
            color: #fff;
            font-size: 13px;
            padding: 5px;
            margin: 0;
        }
    }
    .conversationlanding {
        flex: 5;
        height: 100%;
        // font-style: oblique;
        display: flex;
        flex-direction: column;
        justify-content: center; /* vertically aligns items */
        align-items: center; /* horizontally aligns items */
    }
    #imgback{
        display: none;
        float: right;
        width: 98px;
        padding: 5px;
        cursor:pointer;
    }

    #imgback2{
        display: none;
        width:40%;
        cursor:pointer;
        margin-bottom:15px;
    }

    #imgbacka{
        display: none;
        text-align:center;  
    }
}

</style>