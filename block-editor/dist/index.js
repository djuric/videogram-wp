!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=8)}([function(e,t){!function(){e.exports=this.wp.i18n}()},function(e,t){!function(){e.exports=this.wp.element}()},function(e,t){!function(){e.exports=this.wp.components}()},function(e,t){!function(){e.exports=this.wp.blocks}()},function(e,t){!function(){e.exports=this.wp.data}()},function(e,t){!function(){e.exports=this.wp.compose}()},,,function(e,t,n){"use strict";n.r(t);var r=n(0),o=n(3),c=n(1),i=n(2);Object(o.registerBlockType)("videogram/video",{title:Object(r.__)("Video"),description:Object(r.__)("Video block"),icon:"format-video",category:"common",attributes:{embeddedCode:{type:"string",source:"meta",meta:"embedded_code",default:""},length:{type:"string",source:"meta",meta:"length",default:""},featured:{type:"boolean",source:"meta",meta:"featured",default:!1}},edit:function(e){var t=e.attributes,n=t.embeddedCode,o=t.length,u=t.featured,a=e.setAttributes,d=e.className;return Object(c.createElement)("div",{className:d},Object(c.createElement)(i.TextareaControl,{label:Object(r.__)("Embedded Code"),value:n,onChange:function(e){return a({embeddedCode:e})}}),Object(c.createElement)(i.TextControl,{type:"number",label:Object(r.__)("Video length"),value:o,onChange:function(e){return a({length:e})}}),Object(c.createElement)(i.ToggleControl,{label:Object(r.__)("Featured Video"),checked:u,onChange:function(e){return a({featured:e})}}))}});var u=n(4),a=n(5),d=Object(a.compose)([Object(u.withSelect)((function(e){return{excerpt:e("core/editor").getEditedPostAttribute("excerpt")}})),Object(u.withDispatch)((function(e){return{onSetExcerpt:function(t){e("core/editor").editPost({excerpt:t})}}}))])((function(e){var t=e.className,n=e.excerpt,o=e.onSetExcerpt;return Object(c.createElement)(i.TextareaControl,{className:t,value:n,label:Object(r.__)("Video Excerpt"),rows:"5",onChange:function(e){return o(e)}})}));Object(o.registerBlockType)("videogram/excerpt",{title:Object(r.__)("Video Excerpt"),description:Object(r.__)("Excerpt for current video post type."),icon:"excerpt-view",category:"common",edit:d})}]);