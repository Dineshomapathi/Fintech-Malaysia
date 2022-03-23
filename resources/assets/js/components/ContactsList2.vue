<template>
        <div class="contacts-list" id="mode">
            <ul onclick="document.getElementById('maindash').style.display='flex';document.getElementById('mode').style.display='none';return false;">
                <li v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected }">
                    <div class="avatar" v-if="contact.imageurl == null">
                        <!-- <vue-initials-img :name="contact.name"/> -->
                        <img src="https://visitorchat.myfintechweek.my/image/user.jpg">
                    </div>
                    <div class="avatar2" v-else>
                        <!-- <vue-initials-img :name="contact.loginotp"/> -->
                        <img :src="contact.imageurl">
                    </div>
                    <div class="contact">
                        <p class="loginotp" style="font-size: 1rem;font-family: 'DIN Pro', sans-serif !important;" v-if="contact.name != null && contact.name != 'null'">{{ contact.name }}</p>
                        <p class="loginotp" style="font-size: 1rem;font-family: 'DIN Pro', sans-serif !important;" v-else>{{ contact.loginotp }}</p>
                        <p class="booth" style="font-family: 'DIN Pro', sans-serif !important;font-size: 0.8rem;">{{ contact.company }}</p> 
                        <!--<p class="created_at">{{ contact.created_at }}</p> -->
                    </div>
                    <span class="unread" style="font-family: 'DIN Pro', sans-serif !important;" v-if="contact.unread">{{ contact.unread }}</span>
                </li>
            </ul>
        </div>
</template>

<script>
    import _ from 'lodash';

    export default {
        props: {
            contacts: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                isAutoSelected: false,
                selected: this.contacts.length ? this.contacts[0] : null
            };
        },
        mounted(){
        },
        methods: {
            selectContact(contact) {
                this.selected = contact;

                this.$emit('selected', contact);
            }
        },
        computed: {
            sortedContacts() {
                if(!this.isAutoSelected && this.contacts.length > 0){
                    this.isAutoSelected = true;
                    this.selectContact( _.findLast(this.contacts));
                }
                // return _.sortBy(this.contacts, [(contact) => {
                //     // if (contact == this.selected) {
                //     //     return Infinity;
                //     // }

                //     return contact.unread;
                // }],'desc');

                // return _.orderBy(this.contacts, ["updated_at"], ["desc"]);
                return _.orderBy(this.contacts, ["last_message"], ["desc"]);
            }
        }
    }
</script>

<style lang="scss" scoped>
@import url('https://fonts.cdnfonts.com/css/din-pro');

@media (min-width:320px)  { /* smartphones, iPhone, portrait 480x320 phones */
#mode{
    display:none;
}

.contacts-list {
    flex: 2;
    max-height: 99.5vh;
    //height: 100%;
    overflow: auto;
    border-right: 1px solid #00249D;
    
    ul {
        list-style-type: none;
        padding-left: 0;

        li {
            display: flex;
            padding: 2px;
            border-bottom: 1px solid #00249D;
            height: 110px;
            position: relative;
            cursor: pointer;

            &.selected {
                background: #dfdfdf;
            }

            span.unread {
                background: #82e0a8;
                color: #fff;
                position: absolute;
                right: 11px;
                top: 20px;
                display: flex;
                font-weight: 700;
                min-width: 20px;
                justify-content: center;
                align-items: center;
                line-height: 20px;
                font-size: 12px;
                padding: 0 4px;
                border-radius: 3px;
            }

            .avatar {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .avatar2 {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .contact {
                flex: 3;
                font-size: 10px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;

                p {
                    margin: 0px 15px;

                    &.created_at, &.loginotp, &.booth{
                        // font-weight: bold;
                        font-size: 13px;
                        font-family: 'DIN Pro', sans-serif !important;
                    }
                }
            }
        }
    }
}
}
@media (min-width:481px)  { /* portrait e-readers (Nook/Kindle), smaller tablets @ 600 or @ 640 wide. */
#mode{
    display:none;
}

.contacts-list {
    flex: 2;
    max-height: 99.5vh;
    //height: 100%;
    overflow: auto;
    border-right: 1px solid #00249D;
    
    ul {
        list-style-type: none;
        padding-left: 0;

        li {
            display: flex;
            padding: 2px;
            border-bottom: 1px solid #00249D;
            height: 110px;
            position: relative;
            cursor: pointer;

            &.selected {
                background: #dfdfdf;
            }

            span.unread {
                background: #82e0a8;
                color: #fff;
                position: absolute;
                right: 11px;
                top: 20px;
                display: flex;
                font-weight: 700;
                min-width: 20px;
                justify-content: center;
                align-items: center;
                line-height: 20px;
                font-size: 12px;
                padding: 0 4px;
                border-radius: 3px;
            }

            .avatar {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .avatar2 {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .contact {
                flex: 3;
                font-size: 10px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;

                p {
                     margin: 0px 15px;

                    &.created_at, &.loginotp, &.booth{
                        // font-weight: bold;
                        font-size: 13px;
                        font-family: 'DIN Pro', sans-serif !important;
                    }
                }
            }
        }
    }
}
}
@media (min-width:641px)  { /* portrait tablets, portrait iPad, landscape e-readers, landscape 800x480 or 854x480 phones */
#mode{
    display:none;
}

.contacts-list {
    flex: 2;
    max-height: 99.5vh;
    //height: 100%;
    overflow: auto;
    border-right: 1px solid #00249D;
    
    ul {
        list-style-type: none;
        padding-left: 0;

        li {
            display: flex;
            padding: 2px;
            border-bottom: 1px solid #00249D;
            height: 110px;
            position: relative;
            cursor: pointer;

            &.selected {
                background: #dfdfdf;
            }

            span.unread {
                background: #82e0a8;
                color: #fff;
                position: absolute;
                right: 11px;
                top: 20px;
                display: flex;
                font-weight: 700;
                min-width: 20px;
                justify-content: center;
                align-items: center;
                line-height: 20px;
                font-size: 12px;
                padding: 0 4px;
                border-radius: 3px;
            }

            .avatar {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .avatar2 {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .contact {
                flex: 3;
                font-size: 10px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;

                p {
                     margin: 0px 15px;

                    &.created_at, &.loginotp, &.booth{
                        // font-weight: bold;
                        font-size: 13px;
                        font-family: 'DIN Pro', sans-serif !important;
                    }
                }
            }
        }
    }
}
}
@media (min-width:768px)  { /* tablet, landscape iPad, lo-res laptops ands desktops */
#mode{
    display:block !important;
}

.contacts-list {
    flex: 2;
    max-height: 99.5vh;
    //height: 100%;
    overflow: auto;
    border-right: 1px solid #00249D;
    
    ul {
        list-style-type: none;
        padding-left: 0;

        li {
            display: flex;
            padding: 2px;
            border-bottom: 1px solid #00249D;
            height: 110px;
            position: relative;
            cursor: pointer;

            &.selected {
                background: #dfdfdf;
            }

            span.unread {
                background: #82e0a8;
                color: #fff;
                position: absolute;
                right: 11px;
                top: 20px;
                display: flex;
                font-weight: 700;
                min-width: 20px;
                justify-content: center;
                align-items: center;
                line-height: 20px;
                font-size: 12px;
                padding: 0 4px;
                border-radius: 3px;
            }

            .avatar {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .avatar2 {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .contact {
                flex: 3;
                font-size: 10px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;

                p {
                     margin: 0px 15px;

                    &.created_at, &.loginotp, &.booth{
                        // font-weight: bold;
                        font-size: 13px;
                        font-family: 'DIN Pro', sans-serif !important;
                    }
                }
            }
        }
    }
}
}
@media (min-width:1025px) { /* big landscape tablets, laptops, and desktops */
#mode{
    display:block !important;
}


.contacts-list {
    flex: 2;
    max-height: 99.5vh;
    //height: 100%;
    overflow: auto;
    border-right: 1px solid #00249D;
    
    ul {
        list-style-type: none;
        padding-left: 0;

        li {
            display: flex;
            padding: 2px;
            border-bottom: 1px solid #00249D;
            height: 110px;
            position: relative;
            cursor: pointer;

            &.selected {
                background: #dfdfdf;
            }

            span.unread {
                background: #82e0a8;
                color: #fff;
                position: absolute;
                right: 11px;
                top: 20px;
                display: flex;
                font-weight: 700;
                min-width: 20px;
                justify-content: center;
                align-items: center;
                line-height: 20px;
                font-size: 12px;
                padding: 0 4px;
                border-radius: 3px;
            }

            .avatar {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width:50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .avatar2 {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .contact {
                flex: 3;
                font-size: 10px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;

                p {
                    margin: 0px 15px;

                    &.created_at, &.loginotp, &.booth{
                        // font-weight: bold;
                        font-size: 13px;
                        font-family: 'DIN Pro', sans-serif !important;
                    }
                }
            }
        }
    }
}
}
@media (min-width:1281px) { /* hi-res laptops and desktops */
#mode{
    display:block !important;
}

.contacts-list {
    flex: 2;
    max-height: 99.5vh;
    //height: 100%;
    overflow: auto;
    border-right: 1px solid #00249D;
    
    ul {
        list-style-type: none;
        padding-left: 0;

        li {
            display: flex;
            padding: 2px;
            border-bottom: 1px solid #00249D;
            height: 110px;
            position: relative;
            cursor: pointer;

            &.selected {
                background: #dfdfdf;
            }

            span.unread {
                background: #82e0a8;
                color: #fff;
                position: absolute;
                right: 11px;
                top: 20px;
                display: flex;
                font-weight: 700;
                min-width: 20px;
                justify-content: center;
                align-items: center;
                line-height: 20px;
                font-size: 12px;
                padding: 0 4px;
                border-radius: 3px;
            }

            .avatar {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .avatar2 {
                flex: 0;
                display: flex;
                align-items: center;

                img {
                    width: 50px;
                    border-radius: 50%;
                    margin: 0px 15px;
                    border: 1px solid black;
                    object-fit: scale-down;
                    height: 50px;
                }
            }

            .contact {
                flex: 3;
                font-size: 10px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;

                p {
                     margin: 0px 15px;

                    &.created_at, &.loginotp, &.booth{
                        // font-weight: bold;
                        font-size: 13px;
                        font-family: 'DIN Pro', sans-serif !important;
                    }
                }
            }
        }
    }
}
}

/*
 *  STYLE 7
 */

#mode::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
	border-radius: 10px;
}

#mode::-webkit-scrollbar
{
	width: 10px;
	background-color: #F5F5F5;
}

#mode::-webkit-scrollbar-thumb
{
	border-radius: 10px;
	background-image: -webkit-gradient(linear,
									   left bottom,
									   left top,
									   color-stop(0.44, rgb(0,36,157)),
									   color-stop(0.72, rgb(50,79,176)),
									   color-stop(0.86, rgb(102,123,196)));
}
</style>