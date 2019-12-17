import React from 'react';
import classNames from 'classnames';

const Button = ({ active, ...props }) => (
  <span
    {...props}
    className={classNames('tool-button', { active })}
  />
);

export default Button;
