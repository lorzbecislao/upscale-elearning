import{b as n,w as i,o as e,a,u as o,Z as $,d as s,c,t as d,k as l,p,O as g}from"./app-b19efd51.js";import{r as y}from"./AcademicCapIcon-4554e65d.js";import{r as k}from"./ArrowCircleRightIcon-f8537c3a.js";import{r as j}from"./ArrowLeftIcon-20391336.js";import{r as w}from"./ClockIcon-989d3173.js";import{r as u}from"./CheckCircleIcon-8759a125.js";import{_ as x}from"./PrimaryButton-3a9c59a6.js";import{_ as r}from"./SecondaryButton-74dd022e.js";import{_ as N}from"./StudentLayout-bdc94524.js";import"./FlashNotifications-3e6bb6a8.js";import"./XIcon-1b05f6c1.js";import"./use-resolve-button-type-871855d6.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./MenuIcon-b77f6d3c.js";const T={class:"py-12"},B={class:"max-w-7xl mx-auto"},S=s("p",{class:"text-base font-inter font-semibold text-gray-dark"}," Back",-1),A={class:"flex items-center pt-6"},O=["src"],R={key:1,class:"h-48 w-48 border object-cover rounded-full",src:"/images/placeholder.jpeg",alt:""},z={class:"flex-1 ml-3"},D={class:"mt-2 text-3xl font-heading font-bold tracking-tight text-gray-900 sm:text-4xl"},E={class:"mt-2 font-heading text-base leading-8 text-gray-600"},I={class:"px-4 bg-white overflow-hidden shadow-sm sm:rounded-lg"},P={class:"mt-4"},Q={class:"divide-y divide-gray-100"},Z={class:"px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"},q=s("dt",{class:"font-bold leading-6 text-primary font-heading"},"Assessment Title",-1),F={class:"mt-1 leading-6 sm:col-span-2 sm:mt-0"},G={class:"px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"},H=s("dt",{class:"font-bold leading-6 text-primary font-heading"},"Assessment Type",-1),J={class:"mt-1 leading-6 sm:col-span-2 sm:mt-0"},K={class:"px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"},L=s("dt",{class:"font-bold leading-6 text-primary font-heading"},"Instruction",-1),M={class:"mt-1 leading-6 sm:col-span-2 sm:mt-0"},U={class:"border-t"},W={key:0,class:"flex justify-center gap-4 px-2 mt-4"},X={key:1,class:"flex gap-6"},Y={key:1,class:"flex justify-center gap-4 px-2 mt-4"},ss={key:2,class:"flex justify-center gap-4 mt-4 px-2"},xs={__name:"Show",props:{assessment:Object,topic:Object},setup(t){const m=t,v=m.assessment.title;function h(){g.visit(m.topic.course.show_route)}function _(){g.post(route("assessment.start",m.assessment.id))}function b(){g.visit(route("assessment.result",m.assessment.id))}function C(){g.visit(m.topic.next_topic_route)}return(ts,f)=>(e(),n(N,null,{default:i(()=>[a(o($),{title:o(v)},null,8,["title"]),s("div",T,[s("div",B,[s("div",{class:"cursor-pointer inline-flex gap-2",onClick:h},[a(o(j),{class:"w-6 h-6 text-black"}),S]),s("div",A,[s("div",null,[t.topic.course.image_url?(e(),c("img",{key:0,class:"h-48 w-48 md:h-56 md:w-56",src:t.topic.course.image_url,alt:""},null,8,O)):(e(),c("img",R))]),s("div",z,[s("p",D,d(t.assessment.title),1),s("p",E,d(t.topic.title),1)])])]),s("div",I,[s("div",P,[s("dl",Q,[s("div",Z,[q,s("dd",F,d(t.assessment.title),1)]),s("div",G,[H,s("dd",J,d(t.assessment.type==1?"Practical":"Quiz"),1)]),s("div",K,[L,s("dd",M,d(t.assessment.instruction),1)])])])]),s("div",U,[t.assessment.type!==1&&t.topic.course.enrolled?(e(),c("div",W,[a(r,{class:"font-heading text-gray-dark text-sm",onClick:h},{default:i(()=>[t.assessment.completed?(e(),n(o(y),{key:1,class:"2-5 h-5"})):(e(),n(o(w),{key:0,class:"w-5 h-5"})),l(" "+d(t.assessment.completed?"View Course":"Take later"),1)]),_:1}),!t.assessment.completed&&t.assessment.type==1?(e(),n(x,{key:0,class:"font-heading text-gray-dark text-sm",onClick:_},{default:i(()=>[a(o(u),{class:"w-5 h-5"}),l(" Start Assessment ")]),_:1})):p("",!0),t.assessment.completed?(e(),c("div",X,[a(x,{class:"!bg-secondary font-heading text-sm h-full"},{default:i(()=>[a(o(u),{class:"w-5 h-5"}),l(" Completed ")]),_:1}),a(r,{class:"font-heading text-gray-dark text-sm",onClick:f[0]||(f[0]=V=>b())},{default:i(()=>[a(o(k),{class:"w-6 h-6"}),l(" View Result ")]),_:1})])):p("",!0)])):t.assessment.type==1?(e(),c("div",Y,[a(r,{class:"font-heading text-gray-dark text-sm",onClick:h},{default:i(()=>[t.assessment.completed?(e(),n(o(y),{key:1,class:"2-5 h-5"})):(e(),n(o(w),{key:0,class:"w-5 h-5"})),l(" View Course ")]),_:1}),!t.assessment.completed&&t.assessment.type==1?(e(),n(x,{key:0,class:"font-heading text-gray-dark text-sm",onClick:_},{default:i(()=>[a(o(u),{class:"w-5 h-5"}),l(" Start Assessment ")]),_:1})):(e(),n(x,{key:1,class:"!bg-secondary font-heading text-sm h-full"},{default:i(()=>[a(o(u),{class:"w-5 h-5"}),l(" Completed ")]),_:1}))])):(e(),c("div",ss,[a(r,{class:"font-heading text-gray-dark text-sm",onClick:h},{default:i(()=>[a(o(y),{class:"w-6 h-6"}),l(" View Course ")]),_:1}),t.topic.next_topic_route?(e(),n(r,{key:0,class:"font-heading text-gray-dark text-sm",onClick:f[1]||(f[1]=V=>C())},{default:i(()=>[a(o(k),{class:"w-6 h-6"}),l(" Next Topic ")]),_:1})):p("",!0)]))])])]),_:1}))}};export{xs as default};
