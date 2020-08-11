/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

/**
 * Blog Javascript
 * Copied from Clean Blog v1.0.0 (http://startbootstrap.com)
 */

// Navigation Scripts to Show Header on Scroll-Up
jQuery(document).ready(function ($) {
    var MQL = 1170;

    //primary navigation slide-in effect
    if ($(window).width() > MQL) {
        var headerHeight = $('.navbar-custom').height();
        $(window).on('scroll', {
                previousTop: 0
            },
            function () {
                var currentTop = $(window).scrollTop();

                //if user is scrolling up
                if (currentTop < this.previousTop) {
                    if (currentTop > 0 && $('.navbar-custom').hasClass('is-fixed')) {
                        $('.navbar-custom').addClass('is-visible');
                    } else {
                        $('.navbar-custom').removeClass('is-visible is-fixed');
                    }
                    //if scrolling down...
                } else {
                    $('.navbar-custom').removeClass('is-visible');
                    if (currentTop > headerHeight && !$('.navbar-custom').hasClass('is-fixed')) {
                        $('.navbar-custom').addClass('is-fixed');
                    }
                }
                this.previousTop = currentTop;
            });
    }

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});

var $config = {

    url                 : '', // 网址，默认使用 window.location.href
    source              : '', // 来源（QQ空间会用到）, 默认读取head标签：<meta name="site" content="http://overtrue" />
    title               : '锋子博客', // 标题，默认读取 document.title 或者 <meta name="title" content="share.js" />
    origin              : '', // 分享 @ 相关 twitter 账号
    description         : '', // 描述, 默认读取head标签：<meta name="description" content="PHP弱类型的实现原理分析" />
    image               : '', // 图片, 默认取网页中第一个img标签
    sites               : ['qzone', 'qq', 'weibo','wechat', 'douban'], // 启用的站点
    disabled            : ['google', 'facebook', 'twitter'], // 禁用的站点
    wechatQrcodeTitle   : '<div class="social-share" data-wechat-qrcode-title="请打开微信扫一扫"></div>', // 微信二维码提示文字
    wechatQrcodeHelper  : '<p>微信里点“发现”，扫一下</p><p>二维码便可将本文分享至朋友圈。</p>'
};

socialShare('.social-share-cs', $config);

requirejs.config({
    paths: {
        share: '//cdn.bootcss.com/social-share.js/1.0.15/js/social-share.min'
    },
})

requirejs(['share'],function (){
//   ele:指定初始化的元素，可以是单个元素也可以是元素数组
    window.socialShare(ele,{
        // settings
    })
})
