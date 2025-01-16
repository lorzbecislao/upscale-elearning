import{_ as j,a as q,r as F,T as O}from"./FlashNotificationsFrontEnd-eb33766e.js";import{e as D,l as V,o as v,b as H,w as y,d as e,a as r,u,k as w,g as L,r as m,c as b,F as S,i as R,t as C}from"./app-b19efd51.js";import{_ as z}from"./Modal-8b7fb719.js";import{_ as G}from"./PrimaryButton-3a9c59a6.js";import{_ as J}from"./SecondaryButton-74dd022e.js";import{T}from"./TextInput-9f73cf15.js";import{_ as K}from"./Pagination-87e350d7.js";import{_ as Q}from"./Toggle-0636531a.js";import"./_plugin-vue_export-helper-c27b6911.js";/* empty css                                                                  */import"./CheckCircleIcon-8759a125.js";import"./XIcon-1b05f6c1.js";import"./dialog-4910b468.js";import"./transition-ff246cea.js";import"./v4-4a60fe23.js";import"./use-resolve-button-type-871855d6.js";const W=e("h5",{class:"font-heading font-bold text-black-darkest"}," Update Admin Details ",-1),X=["onSubmit"],Y={class:"pt-6"},Z={class:"pt-6"},ee={class:"pt-6 flex justify-end gap-3"},te={__name:"EditUserModal",props:{open:Boolean,user:Object},emits:["close","refreshDataTable"],setup(h,{emit:f}){const n=h,t=D({name:n.user?n.user.name:null,email:n.user?n.user.email:null});function d(){t.name="",t.email="",f("close")}V(()=>n.user,o=>{o&&(t.name=o.name,t.email=o.email)});const _=()=>{t.post(route("admin.users.update",n.user.id),{onSuccess:()=>{d(),t.name="",t.email="",f("refreshDataTable")}})};return(o,i)=>(v(),H(z,{open:h.open,onClose:d},{content:y(()=>[W,e("form",{onSubmit:L(_,["prevent"])},[e("div",Y,[r(T,{modelValue:u(t).name,"onUpdate:modelValue":i[0]||(i[0]=c=>u(t).name=c),required:!0,errors:u(t).errors?u(t).errors.name:[],label:"Name"},null,8,["modelValue","errors"])]),e("div",Z,[r(T,{type:"email",modelValue:u(t).email,"onUpdate:modelValue":i[1]||(i[1]=c=>u(t).email=c),required:!0,errors:u(t).errors?u(t).errors.email:[],label:"Email Address"},null,8,["modelValue","errors"])]),e("div",ee,[r(J,{type:"button",onClick:d},{default:y(()=>[w(" Cancel ")]),_:1}),r(G,{class:"!px-8",type:"submit"},{default:y(()=>[w(" Update ")]),_:1})])],40,X)]),_:1},8,["open"]))}},se={class:"px-4 sm:px-6 lg:px-8"},ae={class:"mt-8 flow-root"},oe={class:"-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"},le={class:"inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"},re={class:"min-w-full divide-y divide-gray-300"},ne=e("thead",null,[e("tr",null,[e("th",{scope:"col",class:"px-3 py-3.5 text-left text-sm font-semibold text-gray-900"},"Name "),e("th",{scope:"col",class:"px-3 py-3.5 text-left text-sm font-semibold text-gray-900"},"Email "),e("th",{scope:"col",class:"px-3 py-3.5 text-left text-sm font-semibold text-gray-900"}," Status"),e("th",{scope:"col",class:"relative py-3.5 pl-3 pr-4 sm:pr-0"},[e("span",{class:"sr-only"},"Edit")])])],-1),ie={class:"divide-y divide-gray-200"},ue=["onClick"],ce={class:"whitespace-nowrap px-3 py-4 text-sm text-gray-500"},pe={class:"whitespace-nowrap px-3 py-4 text-sm text-gray-500"},me={class:"relative whitespace-nowrap inline-flex items-center py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0"},Ve={__name:"DataTable",props:{perPage:Number,searchInput:String},setup(h,{expose:f}){const n=m(!1),t=m(null),d=m("id"),_=m("asc"),o=m([]),i=m(null),c=m(!1),g=m(!1),$={icon:"check",header:null},p=(s=1)=>{axios.get("/admin/users/administrators/data-table",{params:{page:s,search:t.value,sort_column:d.value,sort_direction:_.value}}).then(a=>{o.value=a.data}).catch(a=>{console.error(a)})};function E(s){t.value=s,p(1)}V([t,d,_],()=>{p()},{immediate:!0}),f({handleSearch:E,loadData:p});function N(s){if(s){const a=s.match(/page=(\d+)/),l=a?a[1]:1;p(l)}}function B(s){p(s)}function P(s){i.value=s,c.value=!0}function U(s){i.value=s,n.value=!0}const k=D({id:null});function I(s){k.id=s.id,k.patch(route("admin.users.toggleStatus",s),{preserveState:!0,preserveScroll:!0,onSuccess:()=>{p()}})}function A(){axios.post(route("admin.users.delete",i.value.id)).then(s=>{c.value=!1,g.value=!0,$.header="Admin account deleted successfully",p(1)}).catch(s=>{console.error("Delete error:",s)})}return(s,a)=>(v(),b(S,null,[e("div",se,[e("div",ae,[e("div",oe,[e("div",le,[e("table",re,[ne,e("tbody",ie,[(v(!0),b(S,null,R(o.value.data,(l,M)=>(v(),b("tr",{key:M},[e("td",{class:"whitespace-nowrap px-3 py-4 text-sm text-primary hover:text-primary-darker cursor-pointer hover:underline",onClick:x=>s.handleShow(l)},C(l.name),9,ue),e("td",ce,C(l.email),1),e("td",pe,[r(Q,{value:!!l.status,type:"success",onToggleValue:x=>I(l)},null,8,["value","onToggleValue"])]),e("td",me,[r(u(F),{onClick:x=>U(l),class:"mx-1 text-medium-gray w-5 h-5 cursor-pointer"},null,8,["onClick"]),r(O,{onClick:x=>P(l),class:"text-medium-gray cursor-pointer"},null,8,["onClick"])])]))),128))])])])]),r(te,{open:n.value,onClose:a[0]||(a[0]=l=>n.value=!1),user:i.value,onRefreshDataTable:a[1]||(a[1]=l=>p(1))},null,8,["open","user"]),r(j,{open:c.value,onClose:a[2]||(a[2]=l=>c.value=!1),onHandleSubmit:A},null,8,["open"])])]),r(K,{class:"mt-4 px-2",current_page:o.value.current_page,last_page:o.value.last_page,next_page_url:o.value.next_page_url,prev_page_url:o.value.prev_page_url,path:o.value.path,pagination:o.value,search:t.value,sort_column:d.value,sort_direction:_.value,onEmitPage:N,onEmitSpecificPage:B,total_pages:o.value.total},null,8,["current_page","last_page","next_page_url","prev_page_url","path","pagination","search","sort_column","sort_direction","total_pages"]),r(q,{infos:$,icon:"info",state:g.value,onClose:a[3]||(a[3]=l=>g.value=!1)},null,8,["state"])],64))}};export{Ve as default};
