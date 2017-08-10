# woofmark

> Barking up the DOM tree. A modular, progressive, and beautiful Markdown and HTML editor.

Browser support includes every sane browser and **IE9+**.

# Features

- Small and focused
- Progressive, enhance a raw `textarea`
- Markdown, HTML, and WYSIWYG input modes
- Text selection persists even across input modes!
- Built in Undo and Redo

# Notes

By default, woofmark will start in WYSIWYG mode for the first time. It will start with the last chosen mode the next time it is loaded.

## Modifications

Several changes have been applied to make woofmark work (hopefully) flawlessly with Bludit:

- Modified CSS to match with Admin theme
- WYSIWYG mode newline* and saving hack

\*: You need to press enter twice to get a newline since the hack uses `br` to create newlines.

## Known Issues

- Does not play really well with <!-- pagebreak --> in HTML or WYSIWYG modes. Will work just fine in Markdown mode.
- Produces some really ugly `br` for the newlines.
- Too little formatting buttons? I don't know how to extend them yet.

## Plans

- Try to use `p` for newlines intead of `br`? `br` is still really useful for some cases though...