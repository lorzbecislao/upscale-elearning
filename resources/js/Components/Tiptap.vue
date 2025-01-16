<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Editor, EditorContent, BubbleMenu } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link'
import { Color } from '@tiptap/extension-color'
import TextStyle from '@tiptap/extension-text-style'
import CodeBlockLowlight from '@tiptap/extension-code-block-lowlight'
import { common, createLowlight } from 'lowlight';

const emits = defineEmits(['update:modelValue'])

const props = defineProps({
    modelValue: String,
    isEditable: {
        type: Boolean,
        default: true,
    },
})

const editor = ref(null);

onMounted(() => {
    editor.value = new Editor({
        content: props.modelValue,
        editable: props.isEditable,
        onUpdate: ({editor}) => {
            emits('update:modelValue', editor.getHTML());
        },
        editorProps: {
            attributes: {
                class: ' overflow-y-auto outline-none prose max-w-none px-2'
            }
        },
        extensions: [
            StarterKit.configure({
                // Disable an included extension
                history: false,
                heading: {
                    levels: [1, 2, 3, 4]
                },
                bulletList: {
                    HTMLAttributes: {
                        class: 'list-disc'
                    }
                },
                orderedList: {
                    HTMLAttributes: {
                        class: 'list-decimal'
                    }
                },
                codeBlock: false
            }),
            TextStyle,
            Link.configure({
                openOnClick: true,
                HTMLAttributes: {
                    class: 'tiptap-link-class',
                },
            }),
            Color.configure({
                types: ['textStyle'],
            }),
            CodeBlockLowlight.configure({
                lowlight: createLowlight(common)
            })
        ],
    });
});


onBeforeUnmount(() => {
    editor.value.destroy();
});


</script>

<template>
    <div>
        <div v-if="editor">
            <bubble-menu class="bubble-menu" :tippy-options="{ duration: 100 }" :editor="editor">
                <input type="color" @input="editor.chain().focus().setColor($event.target.value).run()"
                    :value="editor.getAttributes('textStyle').color">

                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                    :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }">
                    H1
                </button>
                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                    :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
                    H2
                </button>
                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
                    :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }">
                    H3
                </button>
                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 4 }).run()"
                    :class="{ 'is-active': editor.isActive('heading', { level: 4 }) }">
                    H4
                </button>

                <button type="button" @click="editor.chain().focus().toggleBold().run()"
                    :class="{ 'is-active': editor.isActive('bold') }">
                    Bold
                </button>
                <button type="button" @click="editor.chain().focus().toggleItalic().run()"
                    :class="{ 'is-active': editor.isActive('italic') }">
                    Italic
                </button>
                <button type="button" @click="editor.chain().focus().toggleStrike().run()"
                    :class="{ 'is-active': editor.isActive('strike') }">
                    Strike
                </button>
                <button type="button" @click="editor.chain().focus().toggleCodeBlock().run()"
                    :class="{ 'is-active': editor.isActive('codeBlock') }">
                    Code Block
                </button>
                <button type="button" @click="editor.chain().focus().toggleBulletList().run()"
                    :class="{ 'is-active': editor.isActive('bulletList') }">
                    Bullet list
                </button>
                <button type="button" @click="editor.chain().focus().toggleOrderedList().run()"
                    :class="{ 'is-active': editor.isActive('orderedList') }">
                    Ordered list
                </button>
                <button type="button" @click="editor.chain().focus().setHorizontalRule().run()">
                    Horizontal rule
                </button>
                <button type="button" @click="editor.chain().focus().setHardBreak().run()">
                    Hard break
                </button>
            </bubble-menu>
        </div>

        <editor-content :editor="editor" />
    </div>
</template>

<style lang="scss">
/* Basic editor styles */
.tiptap {
    >*+* {
        margin-top: 0.15em;
    }

    ul,
    ol {
        padding: 0 1rem;
    }

    blockquote {
        padding-left: 1rem;
        border-left: 2px solid rgba(#0D0D0D, 0.1);
    }

    code {
        background-color: rgba(#616161, 0.1);
        color: #616161;
    }

    pre {
        background: #0D0D0D;
        color: #FFF;
        font-family: 'JetBrainsMono', monospace;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;

        code {
            color: inherit;
            padding: 0;
            background: none;
            font-size: 0.8rem;
        }

        .hljs-comment,
        .hljs-quote {
            color: #616161;
        }

        .hljs-variable,
        .hljs-template-variable,
        .hljs-attribute,
        .hljs-tag,
        .hljs-name,
        .hljs-regexp,
        .hljs-link,
        .hljs-name,
        .hljs-selector-id,
        .hljs-selector-class {
            color: #F98181;
        }

        .hljs-number,
        .hljs-meta,
        .hljs-built_in,
        .hljs-builtin-name,
        .hljs-literal,
        .hljs-type,
        .hljs-params {
            color: #FBBC88;
        }

        .hljs-string,
        .hljs-symbol,
        .hljs-bullet {
            color: #B9F18D;
        }

        .hljs-title,
        .hljs-section {
            color: #FAF594;
        }

        .hljs-keyword,
        .hljs-selector-tag {
            color: #70CFF8;
        }

        .hljs-emphasis {
            font-style: italic;
        }

        .hljs-strong {
            font-weight: 700;
        }
    }

    h1 {
        font-size: 2.25rem; /* 36px */
        line-height: 2.5rem; /* 40px */
        font-weight: bold;
    }

    h2 {
        font-size: 1.875rem; /* 30px */
        line-height: 2.25rem; /* 36px */
        font-weight: bold;
    }

    h3 {
        font-size: 1.5rem; /* 24px */
        line-height: 2rem; /* 32px */
        font-weight: bold;
    }
    h4 {
        font-size: 1.25rem; /* 20px */
        line-height: 1.75rem; /* 28px */
        font-weight: bold;
    }

    h5 {
        font-size: 1.125rem; /* 18px */
        line-height: 1.75rem; /* 28px */
        font-weight: bold;
    }

    h6 {
        font-size: 1rem; /* 16px */
        line-height: 1.5rem; /* 24px */
        font-weight: bold;
    }
}

.bubble-menu {
    background-color: #0D0D0D;
    padding: 0.5rem;
    border-radius: 0.5rem;
    width: 500px;
    button {
        border: none;
        background: none;
        color: #FFF;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0 0.2rem;
        opacity: 0.6;

        &:hover,
        &.is-active {
            opacity: 1;
        }
    }
}

input[type="color"] {
    /* CSS properties */
    margin-left: 0.5rem;
    margin-right: 0.5rem;
    /* Example: adding a border */
    /* Example: adjusting the height */
    /* Example: adjusting the width */
}

.tiptap-link-class {
    color: #0b76c7;
    cursor: pointer;
}

</style>
