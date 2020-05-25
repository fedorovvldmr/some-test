import axios from 'axios';

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import {BNavbar, BCollapse, BNavbarNav, BNavItem} from 'bootstrap-vue';
import Rating                                     from './components/Rating';
import {VueEditor}                                from 'vue2-editor';
import NewsForm                                   from './components/NewsForm';
import WhoRated                                   from './directives/WhoRated';

Vue.component('b-navbar', BNavbar);
Vue.component('b-collapse', BCollapse);
Vue.component('b-navbar-nav', BNavbarNav);
Vue.component('b-nav-item', BNavItem);
Vue.component(Rating.name, Rating);
Vue.component('vue-editor', VueEditor);
Vue.component(NewsForm.name, NewsForm);

Vue.directive('whorated', WhoRated);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.$direction   = {
    like:    'like',
    dislike: 'dislike',
};
Vue.prototype.STATUS_OK    = 1;
Vue.prototype.STATUS_ERROR = 0;
Vue.prototype.$user        = user || '';

const app = new Vue({
    el: '#app',
    
    data: {
        newsList: typeof (newsList) !== 'undefined' ? newsList : [],
        news:     typeof (news) !== 'undefined' ? news : {
            id:     null,
            title:  '',
            text:   '',
            rating: 0,
        },
        
        photoList: typeof (photoList) !== 'undefined' ? photoList : [],
        photo:     typeof (photo) !== 'undefined' ? photo : {},
        
        openForm: false,
        title:    window.title || '',
    },
    
    methods: {
        /**
         * Удалить новость
         * @param {int} id
         * @param {boolean} redirect
         */
        removeNews(id, redirect = false) {
            if(confirm('Вы уверены что хотите удалить эту новость?')) {
                let redirectURI = redirect ? '/news' : '';
                this.remove('news', id, redirectURI, () => {
                    this.$delete(this.newsList, id);
                });
            }
        },
        
        /**
         * Удалить фото
         * @param {int} id
         * @param {boolean} redirect
         */
        removePhoto(id, redirect = false) {
            if(confirm('Вы уверены что хотите удалить это фото?')) {
                let redirectURI = redirect ? '/photos' : '';
                this.remove('photo', id, redirectURI, () => {
                    this.$delete(this.photoList, id);
                });
            }
        },
        
        /**
         * @param {string} type
         * @param {int} id
         * @param {boolean} redirectURI
         */
        remove(type, id, redirectURI, callback) {
            callback = callback || function() {};
            
            axios.get('/ajax/' + type + '/delete/' + id)
                 .then(response => {
                     let data = response.data || {status: this.STATUS_ERROR};
                     if(data.status === this.STATUS_OK) {
                         callback();
                    
                         alert('Удалено');
                    
                         if(redirectURI) {
                             window.location = redirectURI;
                         }
                     } else {
                         alert('Произошло что-то плохое(');
                     }
                 })
                 .catch(error => {
                     console.error(error);
                     alert('Произошло что-то плохое(');
                 });
        },
        
        /**
         * @param {Object} newsData
         * @param {string} uri
         */
        createOrEditNews(newsData, uri) {
            if(!confirm('Сохранить новость?')) {
                return;
            }
            
            return axios.post(uri, newsData);
        },
        
        /**
         * Создание новости
         * @param {object} newsData
         */
        createNews(newsData) {
            this.createOrEditNews(newsData, '/ajax/news/create')
                .then(response => {
                    let data = response.data || {status: this.STATUS_ERROR};
                    if(data.status === this.STATUS_OK) {
                        let news = data.news;
                    
                        // добавление новой новости
                        if(!newsData.id) {
                            this.$set(this.newsList, news.id, {});
                            this.$set(this.newsList[news.id], 'id', news.id);
                        }
                        this.$set(this.newsList[news.id], 'title', news.title);
                        this.$set(this.newsList[news.id], 'text', news.text);
                        this.$set(this.newsList[news.id], 'rating', news.rating);
                    
                        // очистка формы создания
                        this.$set(this.news, 'id', null);
                        this.$set(this.news, 'title', '');
                        this.$set(this.news, 'text', '');
                        this.$set(this.news, 'rating', 0);
                    
                        this.openForm = false;
                    
                        alert('Новость создана');
                    } else {
                        alert('Произошло что-то плохое(');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Произошло что-то плохое(');
                });
        },
        
        /**
         * Редактирование новости
         * @param {object} news
         */
        editNews(news) {
            this.createOrEditNews(news, '/ajax/news/edit/' + news.id)
                .then(response => {
                    let data = response.data || {status: this.STATUS_ERROR};
                    if(data.status === this.STATUS_OK) {
                        let news = data.news;
                    
                        // очистка формы создания
                        this.$set(this.news, 'id', news.id);
                        this.$set(this.news, 'login', news.login);
                        this.$set(this.news, 'title', news.title);
                        this.$set(this.news, 'text', news.text);
                        this.$set(this.news, 'rating', news.rating);
                    
                        this.openForm = false;
                        this.title    = news.title;
                    
                        alert('Новость сохранена');
                    } else {
                        alert('Произошло что-то плохое(');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Произошло что-то плохое(');
                });
        },
    },
});
