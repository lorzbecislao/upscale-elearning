import{r as g}from"./AcademicCapIcon-4554e65d.js";import{r as u}from"./ArrowLeftIcon-20391336.js";import{c as f,a as t,u as o,d as s,t as a,w as i,b as h,p as x,F as y,O as v,o as l,Z as b,k as c}from"./app-b19efd51.js";import{_ as k}from"./PrimaryButton-3a9c59a6.js";import{_ as m}from"./SecondaryButton-74dd022e.js";import{_ as w}from"./Tiptap-68eb52f7.js";import{_ as C}from"./HeaderSection-aa0d82ed.js";import{_ as V}from"./FooterSection-dc9876c1.js";import"./Tiptap.vue_vue_type_style_index_0_lang-0b3a5c23.js";import"./popper-0aa08b12.js";import"./MenuIcon-b77f6d3c.js";import"./XIcon-1b05f6c1.js";import"./dialog-4910b468.js";const B={class:"py-12"},T={class:"max-w-7xl mx-auto"},$=s("p",{class:"text-base font-inter font-semibold text-gray-dark"}," Back",-1),N={class:"max-w-7xl mx-auto"},O={class:"px-4 bg-white overflow-hidden shadow-sm sm:rounded-lg"},j={class:"mt-4 border-t border-gray-100"},P={class:"divide-y divide-gray-100"},E={class:"px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"},F=s("dt",{class:"font-bold leading-6 text-primary"},"Course",-1),L={class:"mt-1 leading-6 sm:col-span-2 sm:mt-0"},S={class:"px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"},U=s("dt",{class:"font-bold leading-6 text-primary"},"Topic",-1),A={class:"mt-1 leading-6 sm:col-span-2 sm:mt-0"},D=s("div",{class:"px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"},[s("dt",{class:"font-bold leading-6 text-primary"},"Assessment Type"),s("dd",{class:"mt-1 leading-6 sm:col-span-2 sm:mt-0"},"Practical ")],-1),I={class:"px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"},Z=s("dt",{class:"font-bold leading-6 text-primary"},"Instruction",-1),q={class:"mt-1 leading-6 sm:col-span-2 sm:mt-0"},z={class:"mt-4"},G={class:"border-t"},H={class:"flex justify-center gap-6 py-6"},J=["href"],cs={__name:"PracticalPage",props:{topic:Object,assessment:Object,isLastTopic:Boolean},setup(e){const p=e;function d(){v.visit(route("home.topic-list",p.topic.course.id))}return(n,r)=>(l(),f(y,null,[t(o(b),{title:"Upscale - Elevate your career with web development skills"}),t(C),s("div",B,[s("div",T,[s("div",{class:"cursor-pointer inline-flex gap-2",onClick:d},[t(o(u),{class:"w-6 h-6 text-black"}),$]),s("div",N,[s("div",O,[s("div",j,[s("dl",P,[s("div",E,[F,s("dd",L,a(e.assessment.course.name),1)]),s("div",S,[U,s("dd",A,a(e.assessment.after_topic.title),1)]),D,s("div",I,[Z,s("dd",q,a(e.assessment.instruction),1)])])])])]),s("div",z,[t(w,{modelValue:e.assessment.content,"onUpdate:modelValue":r[0]||(r[0]=_=>e.assessment.content=_),"is-editable":!1},null,8,["modelValue"])]),s("div",G,[s("div",H,[t(m,{class:"text-gray-dark mr-3 !px-12",type:"button",onClick:d},{default:i(()=>[t(o(g),{class:"w-6 h-6"}),c(" View Course ")]),_:1}),s("a",{href:n.route("register")},[t(k,{type:"button"},{default:i(()=>[c(" Sign in to save your progress ")]),_:1})],8,J),e.isLastTopic?x("",!0):(l(),h(m,{key:0,class:"text-gray-dark ml-3",type:"button",onClick:n.next},{default:i(()=>[c(" Next Topic ")]),_:1},8,["onClick"]))])])])]),t(V)],64))}};export{cs as default};
