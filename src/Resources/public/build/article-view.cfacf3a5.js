(window.webpackJsonp=window.webpackJsonp||[]).push([["article-view"],{4:function(t,e,i){t.exports=i("GdM6")},GdM6:function(t,e,i){"use strict";function n(t,e){for(var i=0;i<e.length;i++){var n=e[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}i.r(e);var a=new(function(){function t(){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.config={},this.initialized=!1}var e,i,a;return e=t,(i=[{key:"initialize",value:function(){var t=window.document.getElementById("js-config");t&&(this.config=JSON.parse(t.textContent),this.initialized=!0)}},{key:"get",value:function(t,e){return this.initialized||this.initialize(),void 0===this.config[t]||null===this.config[t]?e:this.config[t]}}])&&n(e.prototype,i),a&&n(e,a),t}()),r={"#disqus_thread":!1},o=function(t){if(!r[t]){switch(t){case"#disqus_thread":window.disqus_config=function(){this.page.url=a.get("article_url"),this.page.identifier=a.get("page_identifier")},e=window.document,(i=e.createElement("script")).src="//".concat(a.get("discuss_user_name"),".disqus.com/embed.js"),i.setAttribute("data-timestamp",+new Date),(e.head||e.body).appendChild(i);break;default:return}var e,i;r[t]=!0}};$((function(){var t=$('.comments-wrapper a[data-toggle="tab"]');t.on("shown.bs.tab",(function(t){o($(t.target).attr("href"))})),o(t.closest(".active").find('a[data-toggle="tab"]').attr("href"))}))}},[[4,"runtime"]]]);