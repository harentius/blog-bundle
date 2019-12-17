import { Editor } from 'slate';

const isBlockActive = (editor, format) => {
  const [match] = Editor.nodes(editor, {
    match: n => n.type === format,
    mode: 'all',
  });

  return !!match;
};

export default isBlockActive;
