import React from 'react';
import classNames from 'classnames';

const Icon = ({ icon, children }) => (
  <span className={classNames('fa', { [icon]: !!icon, 'tool-icon-text': !!children })}>
    { children }
  </span>
);

export default Icon;
