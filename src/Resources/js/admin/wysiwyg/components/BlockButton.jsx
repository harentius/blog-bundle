import React from 'react';
import { useSlate } from 'slate-react';
import Button from './Button';
import Icon from './Icon';
import isBlockActive from '../services/isBlockActive';

const BlockButton = ({ format, icon, text }) => {
  const editor = useSlate();
  return (
    <Button
      active={isBlockActive(editor, format)}
      onMouseDown={event => {
        event.preventDefault();
        editor.exec({ type: 'format_block', format });
      }}
    >
      <Icon icon={icon}>{text}</Icon>
    </Button>
  );
};

export default BlockButton;
