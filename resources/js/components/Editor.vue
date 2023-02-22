<template>
    <EditorContent :editor="editor" class="ProseMirror"></EditorContent>
</template>

<script>
import {Editor, EditorContent} from "@tiptap/vue-3";
import {StarterKit} from "@tiptap/starter-kit";

export default {
    name: "Editor",

    components: {EditorContent},

    props: {
        modelValue: {
            type: String,
            default: '',
        },
    },

    data() {
        return {
            editor: null
        }
    },

    emits: ['update:modelValue'],

    watch: {
        modelValue(value) {
            const isSame = this.editor.getHTML() === value

            if (isSame) {
                return
            }

            this.editor.commands.setContent(value, false)
        },
    },

    mounted() {
        this.editor = new Editor({
            extensions: [
                StarterKit,
            ],
            content: this.modelValue,
            onUpdate: () => {
                this.$emit('update:modelValue', this.editor.getHTML())
            },
            onBlur: () => {

            }
        })
    },

    beforeUnmount() {
        this.editor.destroy()
    },
}
</script>

<style lang="scss">
/* Basic editor styles */
.ProseMirror {
    > * + * {
        margin-top: 0.75em;
    }

    code {
        background-color: rgba(#616161, 0.1);
        color: #616161;
    }
}

.content {
    padding: 1rem 0 0;

    h3 {
        margin: 1rem 0 0.5rem;
    }

    pre {
        border-radius: 5px;
        color: #333;
    }

    code {
        display: block;
        white-space: pre-wrap;
        font-size: 0.8rem;
        padding: 0.75rem 1rem;
        background-color:#e9ecef;
        color: #495057;
    }
}
</style>
