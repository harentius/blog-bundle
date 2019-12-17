import React from 'react';

const Toolbar = React.forwardRef(({ className, ...props }, ref) => (
  <div
    className="toolbar"
    {...props}
    ref={ref}
  />
));

export default Toolbar;
