Footnotes
=========

The plugin allows to add in an easy way footnotes to a text. There is no need for numbering the footnotes.

The footnotes have a link to go back to the previous reading position.

The plugin uses Footnoted from Jacob Heftmann:

https://github.com/jheftmann/footnoted

Usage
-----

To insert the number of the footnote add ```<sup class="footnoted"></sup>``` to the text.

*Example*

```
This is a sentence with a footnote.<sup class="footnoted"></sup>
```

Add the footnote as element of an ordered list at the end of the text. Give the container of the list elements the ID "footnotes". 

*Example*

```
<ol id="footnotes">
    <li>This is the footnote to the sentence.</li>
</ol>
```

Versions
--------

0.1, July, 2017
- Release.
