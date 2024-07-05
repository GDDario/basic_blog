const container = document.getElementById('editor');
const content = document.getElementById('content');

const options = {
  modules: {
    'toolbar': [
      [{ 'font': [] }, { 'size': [] }],
      ['bold', 'italic', 'underline', 'strike'],
      [{ 'color': [] }, { 'background': [] }],
      [{ 'script': 'super' }, { 'script': 'sub' }],
      [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block'],
      [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
      ['direction', { 'align': [] }],
      ['link', 'image', 'video', 'formula'],
      ['clean']
    ]
  },
  placeholder: 'The posts content goes here...',
  theme: 'snow'
};
const quill = new Quill(container, options);

quill.on('text-change', (delta, oldDelta, source) => {
  content.value = quill.getSemanticHTML();
});
