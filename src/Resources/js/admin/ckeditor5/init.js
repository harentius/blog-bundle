import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
import Underline from '@ckeditor/ckeditor5-basic-styles/src/underline';
import Strikethrough from '@ckeditor/ckeditor5-basic-styles/src/strikethrough';
import CodeBlock from '@ckeditor/ckeditor5-code-block/src/codeblock';
import Aligment from '@ckeditor/ckeditor5-alignment/src/alignment';
import UploadAdapter from '@ckeditor/ckeditor5-adapter-ckfinder/src/uploadadapter';
import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold';
import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic';
import BlockQuote from '@ckeditor/ckeditor5-block-quote/src/blockquote';
import CKFinder from '@ckeditor/ckeditor5-ckfinder/src/ckfinder';
import EasyImage from '@ckeditor/ckeditor5-easy-image/src/easyimage';
import Heading from '@ckeditor/ckeditor5-heading/src/heading';
import Image from '@ckeditor/ckeditor5-image/src/image';
import ImageCaption from '@ckeditor/ckeditor5-image/src/imagecaption';
import ImageStyle from '@ckeditor/ckeditor5-image/src/imagestyle';
import ImageToolbar from '@ckeditor/ckeditor5-image/src/imagetoolbar';
import ImageUpload from '@ckeditor/ckeditor5-image/src/imageupload';
import Indent from '@ckeditor/ckeditor5-indent/src/indent';
import Link from '@ckeditor/ckeditor5-link/src/link';
import List from '@ckeditor/ckeditor5-list/src/list';
import MediaEmbed from '@ckeditor/ckeditor5-media-embed/src/mediaembed';
import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph';
import Table from '@ckeditor/ckeditor5-table/src/table';
import TableToolbar from '@ckeditor/ckeditor5-table/src/tabletoolbar';
import ReadMore from './readmore/ReadMore';
import './style.css';

const init = (selector) => {
  document.querySelectorAll(selector).forEach((el) => {
    ClassicEditor.create(el, {
      plugins: [
        Underline,
        Strikethrough,
        CodeBlock,
        Aligment,
        ReadMore,
        UploadAdapter,
        Bold,
        Italic,
        BlockQuote,
        CKFinder,
        EasyImage,
        Heading,
        Image,
        ImageCaption,
        ImageStyle,
        ImageToolbar,
        ImageUpload,
        Indent,
        Link,
        List,
        MediaEmbed,
        Paragraph,
        Table,
        TableToolbar,
      ],
      language: 'en',
      toolbar: {
        items: [
          'bold', 'italic', 'underline', 'strikethrough', '|',
          'heading', '|',
          'bulletedList', 'numberedList', '|',
          'alignment', '|',
          'link', 'codeblock', 'imageUpload', 'mediaEmbed', '|',
          'blockQuote', 'insertTable',
          'readMore', '|',
        ],
      },
      image: {
        toolbar: [
          'imageStyle:full',
          'imageStyle:side',
          '|',
          'imageTextAlternative',
        ],
      },
      table: {
        contentToolbar: [
          'tableColumn',
          'tableRow',
          'mergeTableCells',
        ],
      },
      codeBlock: {
        languages: [
          { language: 'plaintext', label: 'Plain text' },
          { language: 'bash', label: 'Bash' },
          { language: 'c', label: 'C' },
          { language: 'cs', label: 'C#' },
          { language: 'cpp', label: 'C++' },
          { language: 'css', label: 'CSS' },
          { language: 'diff', label: 'Diff' },
          { language: 'xml', label: 'HTML/XML' },
          { language: 'java', label: 'Java' },
          { language: 'javascript', label: 'JavaScript' },
          { language: 'php', label: 'PHP' },
          { language: 'python', label: 'Python' },
          { language: 'ruby', label: 'Ruby' },
          { language: 'typescript', label: 'TypeScript' },
        ],
      },
      mediaEmbed: {
        previewsInData: true,
      },
      // TODO
      // wordcount: {
      //   showParagraphs: false,
      // },
      // filebrowserUploadUrl: window.Routing.generate('admin_harentius_blog_article_upload'),
      // filebrowserBrowseUrl:
      // window.Routing.generate('admin_harentius_blog_article_browse', { type: 'image' }),
      // filebrowserAudioBrowseUrl:
      // window.Routing.generate('admin_harentius_blog_article_browse', { type: 'audio' }),
    });
  });
};

export default init;
