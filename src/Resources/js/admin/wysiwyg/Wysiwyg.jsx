import React, { useCallback, useMemo, useState } from 'react';
import isHotkey from 'is-hotkey';
import { Editable, withReact, Slate } from 'slate-react';
import { createEditor } from 'slate';
import { withHistory } from 'slate-history';
import BlockButton from './components/BlockButton';
import MarkButton from './components/MarkButton';
import Element from './components/Element';
import Leaf from './components/Leaf';
import withLists from './services/withLists';
import './style.scss';
// import hljs from '../../hljs';
import Toolbar from './components/Toolbar';

const HOTKEYS = {
  'mod+b': 'bold',
  'mod+i': 'italic',
  'mod+u': 'underline',
  'mod+`': 'code',
};

const initialValue = [
  {
    type: 'paragraph',
    children: [
      { text: '' },
    ],
  },
];

const Wysiwyg = () => {
  const [value, setValue] = useState(initialValue);
  const renderElement = useCallback(props => <Element {...props} />, []);
  const renderLeaf = useCallback(props => <Leaf {...props} />, []);
  const editor = useMemo(
    () => withLists(withHistory(withReact(createEditor()))),
    [],
  );

  return (
    <Slate editor={editor} value={value} onChange={setValue}>
      <Toolbar>
        <MarkButton format="bold" icon="fa-bold" />
        <MarkButton format="italic" icon="fa-italic" />
        <MarkButton format="underline" icon="fa-underline" />
        <MarkButton format="code" icon="fa-code" />
        <BlockButton format="heading-one" text="H1" />
        <BlockButton format="heading-two" text="H2" />
        <BlockButton format="block-quote" icon="fa-quote-right" />
        <BlockButton format="numbered-list" icon="fa-list-ol" />
        <BlockButton format="bulleted-list" icon="fa-list-ul" />
      </Toolbar>
      <Editable
        renderElement={renderElement}
        renderLeaf={renderLeaf}
        placeholder="Enter some rich text…"
        spellCheck
        autoFocus
        onKeyDown={event => {
          for (const hotkey in HOTKEYS) {
            if (isHotkey(hotkey, event)) {
              event.preventDefault();
              const mark = HOTKEYS[hotkey];
              editor.exec({
                type: 'format_text',
                properties: { [mark]: true },
              });
            }
          }
        }}
      />
    </Slate>
  );
};

export default Wysiwyg;
