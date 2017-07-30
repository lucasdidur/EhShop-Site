/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

'use strict';

(function()
{
  CKEDITOR.dialog.add('scoreboard', function(editor)
  {
    var plugin = CKEDITOR.plugins.scoreboard;

    var setupParams = function(page, data)
    {
      if (data[page])
        this.setValue(data[page][this.id] || '');
    };

    var commitParams = function(page, data)
    {
      if (!data[page])
        data[page] = {};

      data[page][this.id] = this.getValue() || '';
    };

    var scoreboardLang = editor.lang.scoreboard;

    // définition de la popup
    return {
      title: scoreboardLang.title,
      minWidth: 350,
      minHeight: 230,
      contents:
      [
        {
          id: 'info',
          //requiredContent: 'a[target]', // This is not fully correct, because some target option requires JS.
          label: scoreboardLang.title,
          title: scoreboardLang.title,
          elements:
          [
            {
              type: 'text',
              id: 'player',
              label: scoreboardLang.playerText,
              required: true,
              onLoad: function()
              {
                this.allowOnChange = true;
              },
              onKeyUp: function()
              {
                /*
                this.allowOnChange = false;
                var url = this.getValue();
                this.allowOnChange = true;
                */
              },
              onChange: function()
              {
                if (this.allowOnChange) // Dont't call on dialog load.
                  this.onKeyUp();
              },
              validate: function()
              {
                var dialog = this.getDialog();

                var func = CKEDITOR.dialog.validate.notEmpty(scoreboardLang.playerNoText);
                return func.apply(this);
              },
              setup: function(data)
              {
                this.allowOnChange = false;
                this.setValue(data.player);
                this.allowOnChange = true;
              },
              commit: function(data)
              {
                // IE will not trigger the onChange event if the mouse has been used
                // to carry all the operations #4724
                this.onChange();

                data.player = this.getValue();
                this.allowOnChange = false;
              }
            },
            {
              type: 'text',
              id: 'objective',
              label: scoreboardLang.objectiveText,
              required: true,
              onLoad: function()
              {
                this.allowOnChange = true;
              },
              onKeyUp: function()
              {
                /*
                this.allowOnChange = false;
                var url = this.getValue();
                this.allowOnChange = true;
                */
              },
              onChange: function()
              {
                if (this.allowOnChange) // Dont't call on dialog load.
                  this.onKeyUp();
              },
              validate: function()
              {
                var dialog = this.getDialog();

                var func = CKEDITOR.dialog.validate.notEmpty(scoreboardLang.objectiveNoText);
                return func.apply(this);
              },
              setup: function(data)
              {
                this.allowOnChange = false;
                this.setValue(data.objective);
                this.allowOnChange = true;
              },
              commit: function(data)
              {
                // IE will not trigger the onChange event if the mouse has been used
                // to carry all the operations #4724
                this.onChange();

                data.objective = this.getValue();
                this.allowOnChange = false;
              }
            },
            // {
            //   type: 'html',
            //   html: '<div class="info">' + scoreboardLang.SelectorNoText + '</div>',
            // },
          ]
        }
      ],
      onShow: function()
      {
        var editor = this.getParentEditor(),
          selection = editor.getSelection(),
          element = null;

        // Fill in all the relevant fields if there's already one link selected.
        if (element = plugin.getSelectedScoreboard(editor))
        {
          // Don't change selection if some element is already selected.
          // For example - don't destroy fake selection.
          if (!selection.getSelectedElement())
            selection.selectElement(element);
        }
        else
        {
          element = null;
        }

        var data = plugin.parseScoreboardAttributes(editor, element);

        // Record down the selected element in the dialog.
        this._.selectedElement = element;

        this.setupContent(data);
      },
      onOk: function()
      {
        var data = {};

        // Collect data from fields.
        this.commitContent(data);

        data.scoreboard = data.player + "§§" + data.objective;
        var scoreboard_text = data.player + "->" + data.objective;

        // create the new tag
        var oTag = editor.document.createElement('code');
        oTag.setAttribute('class', 'scoreboard');
        oTag.setAttribute('data-player', data.player);
        oTag.setAttribute('data-objective', data.objective);
        oTag.setAttribute('data-scoreboard', data.scoreboard);
        oTag.setText(scoreboard_text);

        if (!this._.selectedElement)
        {
          var selection = editor.getSelection();
          var range = selection.getRanges()[0];
          range.deleteContents();
          range.select(); // Select emptied range to place the caret in its place.
          editor.insertElement(oTag);
        }
        else
        {
          // We're only editing an existing link, so just overwrite the attributes.
          var element = this._.selectedElement;
          element.setHtml(oTag.getOuterHtml()) // add the new code
          element.remove(true); // remove the old code

          delete this._.selectedElement;
        }
      },
      
      onLoad: function()
      {
      },
      
      onFocus: function()
      {
      }
    };
  });
})();
