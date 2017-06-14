<template>
  <quill-editor
       :options="editor_options"
       @blur="onEditorBlur($event)"
       @focus="onEditorFocus($event)"
       @ready="onEditorReady($event)"
       @input="onInput($event)"
       :value="value" />
</template>

<script>
    export default {
      props: {
        value: ''
      },
      data() {
        return {
          editor_options: {
            placeholder: "Escreva seu texto aqui...",
            modules: {
                toolbar: [
                  [{ header: [1, 2, false] }],
                  ['bold', 'italic', 'underline'],
                  ['code-block'],
                  [{ 'font': [] }],
                  [{ 'align': 'justify'}, { 'align': 'center'}, { 'align': 'right'},],
                  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                  ['link'],
                  [{ 'indent': '-1'}, { 'indent': '+1' }]
                ]
              },
          },
        }
      },
      methods: {
        onInput(value) {
          this.$emit('input', value);
        },
        onEditorBlur(editor) {
          // console.log('editor blur!', editor)
        },
        onEditorFocus(editor) {
          // console.log('editor focus!', editor)
        },
        onEditorReady(editor) {
          // console.log('editor ready!', editor)
        },
        onEditorChange({ editor, html, text }) {

          // console.log('editor change!', editor, html, text)
          this.content = html
          this.$emit('change', html);
        }
      },
      // get the current quill instace object.
    computed: {
      editor() {
        return this.$refs.myQuillEditor.quill
      }
    },
    mounted() {
      // you can use current editor object to do something(quill methods)
      // console.log('this is current quill instance object', this.editor)
    }
  }

  //https://github.com/surmon-china/vue-quill-editor
  //https://quilljs.com/docs/modules/toolbar/
</script>
