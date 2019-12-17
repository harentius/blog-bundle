import { Editor } from 'slate';
import isBlockActive from './isBlockActive';

const LIST_TYPES = ['numbered-list', 'bulleted-list'];

const resolveListType = (isActive, isList, format) => {
  if (isActive) {
    return 'paragraph';
  }

  if (isList) {
    return 'list-item';
  }

  return format;
};

const withLists = editor => {
  const { exec } = editor;

  editor.exec = command => {
    if (command.type === 'format_block') {
      const { format } = command;
      const isActive = isBlockActive(editor, format);
      const isList = LIST_TYPES.includes(format);

      for (const f of LIST_TYPES) {
        Editor.unwrapNodes(editor, { match: n => n.type === f, split: true })
      }

      Editor.setNodes(editor, {
        type: resolveListType(isActive, isList, format),
      });

      if (!isActive && isList) {
        Editor.wrapNodes(editor, { type: format, children: [] });
      }
    } else {
      exec(command);
    }
  };

  return editor;
};

export default withLists;
