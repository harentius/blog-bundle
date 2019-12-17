import React from 'react';
import { useSlate } from 'slate-react';
import Button from './Button';
import Icon from './Icon';
import isMarkActive from '../services/isMarkActive';

const MarkButton = ({ format, icon }) => {
  const editor = useSlate();
  return (
    <Button
      active={isMarkActive(editor, format)}
      onMouseDown={event => {
        event.preventDefault();
        editor.exec({ type: 'format_text', properties: { [format]: true } });
      }}
    >
      <Icon icon={icon}/>
    </Button>
  );
};

export default MarkButton;
