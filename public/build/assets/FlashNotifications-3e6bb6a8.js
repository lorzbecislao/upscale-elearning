import{i as ae,t as C,u as O,o as m,a as q,b as D,A as k,l as Z,N as P,c as g,w as le,d as ne,h as se,v as re,e as V,_ as Q,O as oe}from"./XIcon-1b05f6c1.js";import{s as Y}from"./use-resolve-button-type-871855d6.js";import{r as b,L as F,y as _,_ as B,x,q as N,X as L,$ as A,E as M,o as S,b as T,a as j,c as R,d as w,l as ue,Y as ie,w as ce,I as de,u as pe,t as H,p as ve,W as fe}from"./app-b19efd51.js";import{_ as X}from"./_plugin-vue_export-helper-c27b6911.js";import{r as me}from"./CheckCircleIcon-8759a125.js";function U(t){return[t.screenX,t.screenY]}function ge(){let t=b([-1,-1]);return{wasMoved(s){let l=U(s);return t.value[0]===l[0]&&t.value[1]===l[1]?!1:(t.value=l,!0)},update(s){t.value=U(s)}}}function he({container:t,accept:s,walk:l,enabled:r}){F(()=>{let e=t.value;if(!e||r!==void 0&&!r.value)return;let a=ae(t);if(!a)return;let o=Object.assign(d=>s(d),{acceptNode:s}),c=a.createTreeWalker(e,NodeFilter.SHOW_ELEMENT,o,!1);for(;c.nextNode();)l(c.currentNode)})}function be(t){throw new Error("Unexpected object: "+t)}var I=(t=>(t[t.First=0]="First",t[t.Previous=1]="Previous",t[t.Next=2]="Next",t[t.Last=3]="Last",t[t.Specific=4]="Specific",t[t.Nothing=5]="Nothing",t))(I||{});function ye(t,s){let l=s.resolveItems();if(l.length<=0)return null;let r=s.resolveActiveIndex(),e=r??-1;switch(t.focus){case 0:{for(let a=0;a<l.length;++a)if(!s.resolveDisabled(l[a],a,l))return a;return r}case 1:{e===-1&&(e=l.length);for(let a=e-1;a>=0;--a)if(!s.resolveDisabled(l[a],a,l))return a;return r}case 2:{for(let a=e+1;a<l.length;++a)if(!s.resolveDisabled(l[a],a,l))return a;return r}case 3:{for(let a=l.length-1;a>=0;--a)if(!s.resolveDisabled(l[a],a,l))return a;return r}case 4:{for(let a=0;a<l.length;++a)if(s.resolveId(l[a],a,l)===t.id)return a;return r}case 5:return null;default:be(t)}}var we=(t=>(t[t.Open=0]="Open",t[t.Closed=1]="Closed",t))(we||{});let J=Symbol("DisclosureContext");function K(t){let s=A(J,null);if(s===null){let l=new Error(`<${t} /> is missing a parent <Disclosure /> component.`);throw Error.captureStackTrace&&Error.captureStackTrace(l,K),l}return s}let G=Symbol("DisclosurePanelContext");function Ie(){return A(G,null)}let Je=_({name:"Disclosure",props:{as:{type:[Object,String],default:"template"},defaultOpen:{type:[Boolean],default:!1}},setup(t,{slots:s,attrs:l}){let r=b(t.defaultOpen?0:1),e=b(null),a=b(null),o={buttonId:b(`headlessui-disclosure-button-${C()}`),panelId:b(`headlessui-disclosure-panel-${C()}`),disclosureState:r,panel:e,button:a,toggleDisclosure(){r.value=O(r.value,{0:1,1:0})},closeDisclosure(){r.value!==1&&(r.value=1)},close(c){o.closeDisclosure();let d=(()=>c?c instanceof HTMLElement?c:c.value instanceof HTMLElement?m(c):m(o.button):m(o.button))();d==null||d.focus()}};return B(J,o),q(x(()=>O(r.value,{0:D.Open,1:D.Closed}))),()=>{let{defaultOpen:c,...d}=t,p={open:r.value===0,close:o.close};return k({theirProps:d,ourProps:{},slot:p,slots:s,attrs:l,name:"Disclosure"})}}}),Ge=_({name:"DisclosureButton",props:{as:{type:[Object,String],default:"button"},disabled:{type:[Boolean],default:!1},id:{type:String,default:null}},setup(t,{attrs:s,slots:l,expose:r}){let e=K("DisclosureButton"),a=Ie(),o=x(()=>a===null?!1:a.value===e.panelId.value);N(()=>{o.value||t.id!==null&&(e.buttonId.value=t.id)}),L(()=>{o.value||(e.buttonId.value=null)});let c=b(null);r({el:c,$el:c}),o.value||F(()=>{e.button.value=c.value});let d=Y(x(()=>({as:t.as,type:s.type})),c);function p(){var u;t.disabled||(o.value?(e.toggleDisclosure(),(u=m(e.button))==null||u.focus()):e.toggleDisclosure())}function n(u){var v;if(!t.disabled)if(o.value)switch(u.key){case g.Space:case g.Enter:u.preventDefault(),u.stopPropagation(),e.toggleDisclosure(),(v=m(e.button))==null||v.focus();break}else switch(u.key){case g.Space:case g.Enter:u.preventDefault(),u.stopPropagation(),e.toggleDisclosure();break}}function h(u){switch(u.key){case g.Space:u.preventDefault();break}}return()=>{var u;let v={open:e.disclosureState.value===0},{id:f,...i}=t,y=o.value?{ref:c,type:d.value,onClick:p,onKeydown:n}:{id:(u=e.buttonId.value)!=null?u:f,ref:c,type:d.value,"aria-expanded":e.disclosureState.value===0,"aria-controls":e.disclosureState.value===0||m(e.panel)?e.panelId.value:void 0,disabled:t.disabled?!0:void 0,onClick:p,onKeydown:n,onKeyup:h};return k({ourProps:y,theirProps:i,slot:v,attrs:s,slots:l,name:"DisclosureButton"})}}}),et=_({name:"DisclosurePanel",props:{as:{type:[Object,String],default:"div"},static:{type:Boolean,default:!1},unmount:{type:Boolean,default:!0},id:{type:String,default:null}},setup(t,{attrs:s,slots:l,expose:r}){let e=K("DisclosurePanel");N(()=>{t.id!==null&&(e.panelId.value=t.id)}),L(()=>{e.panelId.value=null}),r({el:e.panel,$el:e.panel}),B(G,e.panelId);let a=Z(),o=x(()=>a!==null?(a.value&D.Open)===D.Open:e.disclosureState.value===0);return()=>{var c;let d={open:e.disclosureState.value===0,close:e.close},{id:p,...n}=t,h={id:(c=e.panelId.value)!=null?c:p,ref:e.panel};return k({ourProps:h,theirProps:n,slot:d,attrs:s,slots:l,features:P.RenderStrategy|P.Static,visible:o.value,name:"DisclosurePanel"})}}}),z=/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g;function W(t){var s,l;let r=(s=t.innerText)!=null?s:"",e=t.cloneNode(!0);if(!(e instanceof HTMLElement))return r;let a=!1;for(let c of e.querySelectorAll('[hidden],[aria-hidden],[role="img"]'))c.remove(),a=!0;let o=a?(l=e.innerText)!=null?l:"":r;return z.test(o)&&(o=o.replace(z,"")),o}function xe(t){let s=t.getAttribute("aria-label");if(typeof s=="string")return s.trim();let l=t.getAttribute("aria-labelledby");if(l){let r=l.split(" ").map(e=>{let a=document.getElementById(e);if(a){let o=a.getAttribute("aria-label");return typeof o=="string"?o.trim():W(a).trim()}return null}).filter(Boolean);if(r.length>0)return r.join(", ")}return W(t).trim()}function Se(t){let s=b(""),l=b("");return()=>{let r=m(t);if(!r)return"";let e=r.innerText;if(s.value===e)return l.value;let a=xe(r).trim().toLowerCase();return s.value=e,l.value=a,a}}var De=(t=>(t[t.Open=0]="Open",t[t.Closed=1]="Closed",t))(De||{}),ke=(t=>(t[t.Pointer=0]="Pointer",t[t.Other=1]="Other",t))(ke||{});function _e(t){requestAnimationFrame(()=>requestAnimationFrame(t))}let ee=Symbol("MenuContext");function E(t){let s=A(ee,null);if(s===null){let l=new Error(`<${t} /> is missing a parent <Menu /> component.`);throw Error.captureStackTrace&&Error.captureStackTrace(l,E),l}return s}let tt=_({name:"Menu",props:{as:{type:[Object,String],default:"template"}},setup(t,{slots:s,attrs:l}){let r=b(1),e=b(null),a=b(null),o=b([]),c=b(""),d=b(null),p=b(1);function n(u=v=>v){let v=d.value!==null?o.value[d.value]:null,f=oe(u(o.value.slice()),y=>m(y.dataRef.domRef)),i=v?f.indexOf(v):null;return i===-1&&(i=null),{items:f,activeItemIndex:i}}let h={menuState:r,buttonRef:e,itemsRef:a,items:o,searchQuery:c,activeItemIndex:d,activationTrigger:p,closeMenu:()=>{r.value=1,d.value=null},openMenu:()=>r.value=0,goToItem(u,v,f){let i=n(),y=ye(u===I.Specific?{focus:I.Specific,id:v}:{focus:u},{resolveItems:()=>i.items,resolveActiveIndex:()=>i.activeItemIndex,resolveId:$=>$.id,resolveDisabled:$=>$.dataRef.disabled});c.value="",d.value=y,p.value=f??1,o.value=i.items},search(u){let v=c.value!==""?0:1;c.value+=u.toLowerCase();let f=(d.value!==null?o.value.slice(d.value+v).concat(o.value.slice(0,d.value+v)):o.value).find(y=>y.dataRef.textValue.startsWith(c.value)&&!y.dataRef.disabled),i=f?o.value.indexOf(f):-1;i===-1||i===d.value||(d.value=i,p.value=1)},clearSearch(){c.value=""},registerItem(u,v){let f=n(i=>[...i,{id:u,dataRef:v}]);o.value=f.items,d.value=f.activeItemIndex,p.value=1},unregisterItem(u){let v=n(f=>{let i=f.findIndex(y=>y.id===u);return i!==-1&&f.splice(i,1),f});o.value=v.items,d.value=v.activeItemIndex,p.value=1}};return le([e,a],(u,v)=>{var f;h.closeMenu(),ne(v,se.Loose)||(u.preventDefault(),(f=m(e))==null||f.focus())},x(()=>r.value===0)),B(ee,h),q(x(()=>O(r.value,{0:D.Open,1:D.Closed}))),()=>{let u={open:r.value===0,close:h.closeMenu};return k({ourProps:{},theirProps:t,slot:u,slots:s,attrs:l,name:"Menu"})}}}),at=_({name:"MenuButton",props:{disabled:{type:Boolean,default:!1},as:{type:[Object,String],default:"button"},id:{type:String,default:()=>`headlessui-menu-button-${C()}`}},setup(t,{attrs:s,slots:l,expose:r}){let e=E("MenuButton");r({el:e.buttonRef,$el:e.buttonRef});function a(p){switch(p.key){case g.Space:case g.Enter:case g.ArrowDown:p.preventDefault(),p.stopPropagation(),e.openMenu(),M(()=>{var n;(n=m(e.itemsRef))==null||n.focus({preventScroll:!0}),e.goToItem(I.First)});break;case g.ArrowUp:p.preventDefault(),p.stopPropagation(),e.openMenu(),M(()=>{var n;(n=m(e.itemsRef))==null||n.focus({preventScroll:!0}),e.goToItem(I.Last)});break}}function o(p){switch(p.key){case g.Space:p.preventDefault();break}}function c(p){t.disabled||(e.menuState.value===0?(e.closeMenu(),M(()=>{var n;return(n=m(e.buttonRef))==null?void 0:n.focus({preventScroll:!0})})):(p.preventDefault(),e.openMenu(),_e(()=>{var n;return(n=m(e.itemsRef))==null?void 0:n.focus({preventScroll:!0})})))}let d=Y(x(()=>({as:t.as,type:s.type})),e.buttonRef);return()=>{var p;let n={open:e.menuState.value===0},{id:h,...u}=t,v={ref:e.buttonRef,id:h,type:d.value,"aria-haspopup":"menu","aria-controls":(p=m(e.itemsRef))==null?void 0:p.id,"aria-expanded":e.menuState.value===0,onKeydown:a,onKeyup:o,onClick:c};return k({ourProps:v,theirProps:u,slot:n,attrs:s,slots:l,name:"MenuButton"})}}}),lt=_({name:"MenuItems",props:{as:{type:[Object,String],default:"div"},static:{type:Boolean,default:!1},unmount:{type:Boolean,default:!0},id:{type:String,default:()=>`headlessui-menu-items-${C()}`}},setup(t,{attrs:s,slots:l,expose:r}){let e=E("MenuItems"),a=b(null);r({el:e.itemsRef,$el:e.itemsRef}),he({container:x(()=>m(e.itemsRef)),enabled:x(()=>e.menuState.value===0),accept(n){return n.getAttribute("role")==="menuitem"?NodeFilter.FILTER_REJECT:n.hasAttribute("role")?NodeFilter.FILTER_SKIP:NodeFilter.FILTER_ACCEPT},walk(n){n.setAttribute("role","none")}});function o(n){var h;switch(a.value&&clearTimeout(a.value),n.key){case g.Space:if(e.searchQuery.value!=="")return n.preventDefault(),n.stopPropagation(),e.search(n.key);case g.Enter:if(n.preventDefault(),n.stopPropagation(),e.activeItemIndex.value!==null){let u=e.items.value[e.activeItemIndex.value];(h=m(u.dataRef.domRef))==null||h.click()}e.closeMenu(),Q(m(e.buttonRef));break;case g.ArrowDown:return n.preventDefault(),n.stopPropagation(),e.goToItem(I.Next);case g.ArrowUp:return n.preventDefault(),n.stopPropagation(),e.goToItem(I.Previous);case g.Home:case g.PageUp:return n.preventDefault(),n.stopPropagation(),e.goToItem(I.First);case g.End:case g.PageDown:return n.preventDefault(),n.stopPropagation(),e.goToItem(I.Last);case g.Escape:n.preventDefault(),n.stopPropagation(),e.closeMenu(),M(()=>{var u;return(u=m(e.buttonRef))==null?void 0:u.focus({preventScroll:!0})});break;case g.Tab:n.preventDefault(),n.stopPropagation(),e.closeMenu(),M(()=>re(m(e.buttonRef),n.shiftKey?V.Previous:V.Next));break;default:n.key.length===1&&(e.search(n.key),a.value=setTimeout(()=>e.clearSearch(),350));break}}function c(n){switch(n.key){case g.Space:n.preventDefault();break}}let d=Z(),p=x(()=>d!==null?(d.value&D.Open)===D.Open:e.menuState.value===0);return()=>{var n,h;let u={open:e.menuState.value===0},{id:v,...f}=t,i={"aria-activedescendant":e.activeItemIndex.value===null||(n=e.items.value[e.activeItemIndex.value])==null?void 0:n.id,"aria-labelledby":(h=m(e.buttonRef))==null?void 0:h.id,id:v,onKeydown:o,onKeyup:c,role:"menu",tabIndex:0,ref:e.itemsRef};return k({ourProps:i,theirProps:f,slot:u,attrs:s,slots:l,features:P.RenderStrategy|P.Static,visible:p.value,name:"MenuItems"})}}}),nt=_({name:"MenuItem",inheritAttrs:!1,props:{as:{type:[Object,String],default:"template"},disabled:{type:Boolean,default:!1},id:{type:String,default:()=>`headlessui-menu-item-${C()}`}},setup(t,{slots:s,attrs:l,expose:r}){let e=E("MenuItem"),a=b(null);r({el:a,$el:a});let o=x(()=>e.activeItemIndex.value!==null?e.items.value[e.activeItemIndex.value].id===t.id:!1),c=Se(a),d=x(()=>({disabled:t.disabled,get textValue(){return c()},domRef:a}));N(()=>e.registerItem(t.id,d)),L(()=>e.unregisterItem(t.id)),F(()=>{e.menuState.value===0&&o.value&&e.activationTrigger.value!==0&&M(()=>{var i,y;return(y=(i=m(a))==null?void 0:i.scrollIntoView)==null?void 0:y.call(i,{block:"nearest"})})});function p(i){if(t.disabled)return i.preventDefault();e.closeMenu(),Q(m(e.buttonRef))}function n(){if(t.disabled)return e.goToItem(I.Nothing);e.goToItem(I.Specific,t.id)}let h=ge();function u(i){h.update(i)}function v(i){h.wasMoved(i)&&(t.disabled||o.value||e.goToItem(I.Specific,t.id,0))}function f(i){h.wasMoved(i)&&(t.disabled||o.value&&e.goToItem(I.Nothing))}return()=>{let{disabled:i}=t,y={active:o.value,disabled:i,close:e.closeMenu},{id:$,...te}=t;return k({ourProps:{id:$,ref:a,role:"menuitem",tabIndex:i===!0?void 0:-1,"aria-disabled":i===!0?!0:void 0,disabled:void 0,onClick:p,onFocus:n,onPointerenter:u,onMouseenter:u,onPointermove:v,onMousemove:v,onPointerleave:f,onMouseleave:f},theirProps:{...l,...te},slot:y,attrs:l,slots:s,name:"MenuItem"})}}});function st(t,s){return S(),T("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor","aria-hidden":"true"},[j("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"})])}function rt(t,s){return S(),T("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor","aria-hidden":"true"},[j("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"})])}const Me={},$e={alt:"upscale logo",src:"/images/UD-logo.svg"};function Ce(t,s){return S(),R("img",$e)}const ot=X(Me,[["render",Ce]]),Pe={},Te={xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24",fill:"none"},Re=w("path",{d:"M14.7456 3.35079C13.5413 1.20989 10.4589 1.20989 9.25466 3.35079L2.5583 15.2554C1.37716 17.3552 2.89456 19.9498 5.30376 19.9498H18.6965C21.1057 19.9498 22.6231 17.3552 21.442 15.2554L14.7456 3.35079ZM12.45 15.5999C12.45 15.8484 12.2486 16.0499 12 16.0499C11.7515 16.0499 11.55 15.8484 11.55 15.5999C11.55 15.3514 11.7515 15.1499 12 15.1499C12.2486 15.1499 12.45 15.3514 12.45 15.5999ZM11.55 7.1999C11.55 6.95137 11.7515 6.7499 12 6.7499C12.2486 6.7499 12.45 6.95137 12.45 7.1999V10.7999C12.45 11.0484 12.2486 11.2499 12 11.2499C11.7515 11.2499 11.55 11.0484 11.55 10.7999V7.1999Z",fill:"currentColor",stroke:"white","stroke-width":"1.5"},null,-1),Ee=[Re];function Oe(t,s){return S(),R("svg",Te,Ee)}const Fe=X(Pe,[["render",Oe]]),Be={"aria-live":"assertive",class:"fixed top-6 z-20 right-12 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start"},Ne={class:"w-full flex flex-col items-end space-y-4"},Le={key:0,class:"max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"},Ae={class:"flex justify-between"},je={class:"flex items-start gap-3"},Ke={class:"font-medium font-heading text-black-darkest"},Ve={class:"font-heading text-dark-gray-dark"},He={class:"ml-4 flex-shrink-0 flex"},Ue=w("span",{class:"sr-only"},"Close",-1),ze=w("svg",{"aria-hidden":"true",class:"h-5 w-5",fill:"currentColor",viewBox:"0 0 20 20",xmlns:"http://www.w3.org/2000/svg"},[w("path",{"clip-rule":"evenodd",d:"M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z","fill-rule":"evenodd"})],-1),We=[Ue,ze],ut={__name:"FlashNotifications",setup(t){const s=b(!0);return ue(()=>ie().props.flash,()=>{s.value=!0,setTimeout(()=>{s.value=!1},2e3)},{immediate:!0,deep:!0}),(l,r)=>(S(),R("div",Be,[w("div",Ne,[j(fe,{"enter-active-class":"transform ease-out duration-300 transition","enter-from-class":"translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2","enter-to-class":"translate-y-0 opacity-100 sm:translate-x-0","leave-active-class":"transition ease-in duration-100","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:ce(()=>[l.$page.props.flash.success&&s.value?(S(),R("div",Le,[w("div",{class:de(["p-4",l.$page.props.flash.success.type=="deactivate"?"bg-amber-50":""])},[w("div",Ae,[w("div",je,[l.$page.props.flash.success.type=="deactivate"?(S(),T(Fe,{key:0,"aria-hidden":"true",class:"h-6 w-6 text-[#ffa351]"})):(S(),T(pe(me),{key:1,"aria-hidden":"true",class:"h-6 w-6 text-green-success"})),w("div",null,[w("p",Ke,H(l.$page.props.flash.success.header),1),w("p",Ve,H(l.$page.props.flash.success.message),1)])]),w("div",He,[w("button",{class:"bg-transparent rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none",onClick:r[0]||(r[0]=e=>s.value=!1)},We)])])],2)])):ve("",!0)]),_:1})])]))}};export{tt as I,Je as N,Ge as Q,lt as S,ot as U,et as V,ut as _,st as a,nt as b,at as g,rt as r};
