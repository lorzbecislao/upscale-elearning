import{e as g,c as b,a as r,u as a,d as t,g as v,t as l,h as u,v as m,w as p,F as h,O as q,o as w,Z as k,k as f}from"./app-b19efd51.js";import"./Tiptap.vue_vue_type_style_index_0_lang-0b3a5c23.js";import{_ as Q}from"./PrimaryButton-3a9c59a6.js";import{_ as x}from"./SecondaryButton-74dd022e.js";import{_ as $}from"./HeaderSection-aa0d82ed.js";import{_ as L}from"./FooterSection-dc9876c1.js";import"./MenuIcon-b77f6d3c.js";import"./XIcon-1b05f6c1.js";import"./dialog-4910b468.js";const V={class:"py-12"},N={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},O=["onSubmit"],S={class:"px-4 bg-white overflow-hidden pb-4"},U=t("span",{class:"text-xl"},"Question:",-1),j={class:"mt-3 px-4 text-xl text-primary font-bold"},B={class:"px-4 grid grid-cols-2"},I={class:"flex flex-col mt-3"},T={class:"inline-flex items-center"},C=["id"],F=["for"],D={class:"inline-flex items-center mt-2"},E=["id"],M=["for"],z={class:"flex flex-col mt-3"},P={class:"inline-flex items-center"},R=["id"],Z=["for"],A={class:"inline-flex items-center mt-2"},G=["id"],H=["for"],J={class:"flex justify-center px-2 mt-8"},K=["href"],at={__name:"QuizPage",props:{assessment:Object,question:Object,course_id:Number,nextQuestion:Object,isLastQuestion:{type:Boolean,default:!1}},setup(s){const n=s,_=()=>{o.question_id=n.question.id,o.isLastQuestion=n.isLastQuestion,o.post(route("home.assessments.next",n.assessment.id),{onSuccess:()=>{o.answer=null}})};function y(){q.get(route("home.topic-list",n.course_id))}function d(c){o.answer=c}const o=g({answer:null,question_id:n.question?n.question.id:null,assessment_id:n.assessment?n.assessment.id:null,isLastQuestion:n.isLastQuestion});return(c,e)=>(w(),b(h,null,[r(a(k),{title:"Upscale - Elevate your career with web development skills"}),r($),t("div",V,[t("div",N,[t("form",{onSubmit:v(_,["prevent"])},[t("div",S,[U,t("p",j,l(s.question.question),1),t("div",B,[t("div",I,[t("div",T,[u(t("input",{id:s.question.option_a,onInput:e[0]||(e[0]=i=>d(1)),name:"options-radio",type:"radio","onUpdate:modelValue":e[1]||(e[1]=i=>a(o).answer=i),value:1,class:"h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer",required:!0},null,40,C),[[m,a(o).answer]]),t("label",{for:s.question.option_a,class:"mx-3 block text-lg font-medium text-gray-700"},l(s.question.option_a),9,F)]),t("div",D,[u(t("input",{id:s.question.option_b,onInput:e[2]||(e[2]=i=>d(2)),name:"options-radio",type:"radio","onUpdate:modelValue":e[3]||(e[3]=i=>a(o).answer=i),value:2,class:"h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer",required:!0},null,40,E),[[m,a(o).answer]]),t("label",{for:s.question.option_b,class:"mx-3 block text-lg font-medium text-gray-700"},l(s.question.option_b),9,M)])]),t("div",z,[t("div",P,[u(t("input",{id:s.question.option_c,onInput:e[4]||(e[4]=i=>d(3)),name:"options-radio",type:"radio","onUpdate:modelValue":e[5]||(e[5]=i=>a(o).answer=i),value:3,class:"h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer",required:!0},null,40,R),[[m,a(o).answer]]),t("label",{for:s.question.option_c,class:"mx-3 block text-lg font-medium text-gray-700"},l(s.question.option_c),9,Z)]),t("div",A,[u(t("input",{id:s.question.option_d,onInput:e[6]||(e[6]=i=>d(4)),name:"options-radio",type:"radio","onUpdate:modelValue":e[7]||(e[7]=i=>a(o).answer=i),value:4,class:"h-4 w-4 border-gray-300 text-primary focus:ring-primary cursor-pointer",required:!0},null,40,G),[[m,a(o).answer]]),t("label",{for:s.question.option_d,class:"mx-3 block text-lg font-medium text-gray-700"},l(s.question.option_d),9,H)])])])]),t("div",J,[r(x,{class:"text-gray-dark mr-3",type:"button",onClick:y},{default:p(()=>[f(" Take later ")]),_:1}),t("a",{href:c.route("register")},[r(Q,{type:"button"},{default:p(()=>[f(" Sign in to save your progress ")]),_:1})],8,K),r(x,{class:"text-gray-dark ml-3 !px-8",type:"submit"},{default:p(()=>[f(l(s.isLastQuestion?"Finish":"Next"),1)]),_:1})])],40,O)])]),r(L)],64))}};export{at as default};
