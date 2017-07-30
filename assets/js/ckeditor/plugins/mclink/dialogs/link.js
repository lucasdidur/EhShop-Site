/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

'use strict';

(function()
{
  CKEDITOR.dialog.add('mclink', function(editor)
  {
    var plugin = CKEDITOR.plugins.mclink;

    // Handles the event when the "Type" selection box is changed.
    var linkTypeChanged = function()
    {
      var dialog = this.getDialog(),
        partIds = [ 'openurlOptions', 'commandOptions', 'insertOptions', 'changepageOptions' ],
        typeValue = this.getValue(),
        uploadTab = dialog.definition.getContents( 'upload' ),
        uploadInitiallyHidden = uploadTab && uploadTab.hidden;

      // affichage des options correspondantes en fonction du type selectionné
      for (var i = 0; i < partIds.length; i++)
      {
        var element = dialog.getContentElement('info', partIds[i]);
        if (!element)
          continue;

        element = element.getElement().getParent().getParent();
        if (partIds[i] == 'openurlOptions')
        {
          if (typeValue == 'openurl')
            element.show();
          else
            element.hide();
        }
        else if (partIds[i] == 'insertOptions')
        {
          if (typeValue == 'insert')
            element.show();
          else
            element.hide();
        }
        else if (partIds[i] == 'commandOptions')
        {
          if (typeValue == 'suggestcommand' || typeValue == 'runcommand')
            element.show();
          else
            element.hide();
        }
        else if (partIds[i] == 'changepageOptions')
        {
          if (typeValue == 'changepage')
            element.show();
          else
            element.hide();
        }
      }

      dialog.layout();
    };

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

    var commonLang = editor.lang.common;
    var linkLang = editor.lang.mclink;

    // définition de la popup
    return {
      title: linkLang.mclinkTitle,
      minWidth: 350,
      minHeight: 230,
      contents:
      [
        {
          id: 'info',
          //requiredContent: 'a[target]', // This is not fully correct, because some target option requires JS.
          label: linkLang.info,
          title: linkLang.info,
          elements:
          [
            { // Type de lien
              id: 'linkType',
              type: 'select',
              label: linkLang.type,
              'default': 'openurl',
              items: [
                [ linkLang.typeOpenurl, 'openurl' ],
                [ linkLang.typeSuggestcommand, 'suggestcommand' ],
                [ linkLang.typeRuncommand, 'runcommand' ],
                [ linkLang.typeInsert, 'insert' ],
                [ linkLang.typeChangepage, 'changepage' ],
              ],
              onChange: linkTypeChanged,
              setup: function(data)
              {
                var select = $(this.getInputElement().$);
                $(editor.config.mclinkDisable).each(function()
                {
                  //var diag = this.getDialog();
                  //var infoTab = dialogDefinition.getContents('linkType');

                  select.find('option[value=' + this + ']').remove();
                });

                this.setValue(data.type || 'openurl');
              },
              commit: function(data)
              {
                data.type = this.getValue();
              }
            },
            { // zone "open URL"
              type: 'vbox',
              id: 'openurlOptions',
              children:
              [
                {
                  type: 'text',
                  id: 'url',
                  label: commonLang.url,
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

                    if (dialog.getContentElement('info', 'linkType') && dialog.getValueOf('info', 'linkType') != 'openurl')
                      return true;

                    var func = CKEDITOR.dialog.validate.notEmpty(linkLang.noUrl);
                    return func.apply(this);
                  },
                  setup: function(data)
                  {
                    this.allowOnChange = false;
                    if (data.url)
                      this.setValue(data.url.url);
                    this.allowOnChange = true;
                  },
                  commit: function(data)
                  {
                    // IE will not trigger the onChange event if the mouse has been used
                    // to carry all the operations #4724
                    this.onChange();

                    if (!data.url)
                      data.url = {};

                    data.url.url = this.getValue();
                    this.allowOnChange = false;
                  }
                },
                {
                  type: 'html',
                  html: '<div class="info">' + linkLang.typeOpenurlInfos + '</div>',
                }
              ]
            },
            { // zone "insertion"
              type: 'vbox',
              id: 'insertOptions',
              padding: 1,
              children:
              [
                {
                  type: 'text',
                  id: 'insert',
                  label: linkLang.insertText,
                  required: true,
                  validate: function()
                  {
                    var dialog = this.getDialog();

                    if (!dialog.getContentElement('info', 'linkType') || dialog.getValueOf('info', 'linkType') != 'insert')
                      return true;

                    var func = CKEDITOR.dialog.validate.notEmpty(linkLang.insertNoText);
                    return func.apply(this);
                  },
                  setup: function(data)
                  {
                    if (data.insert)
                      this.setValue(data.insert.text);

                    var linkType = this.getDialog().getContentElement('info', 'linkType');
                    if (linkType && linkType.getValue() == 'insert')
                      this.select();
                  },
                  commit: function(data)
                  {
                    if (!data.insert)
                      data.insert = {};

                    data.insert.text = this.getValue();
                  }
                }
              ],
              setup: function()
              {
                if ( !this.getDialog().getContentElement( 'info', 'linkType' ) )
                  this.getElement().hide();
              }
            },
            { // zone "command*"
              type: 'vbox',
              id: 'commandOptions',
              padding: 1,
              children:
              [
                {
                  type: 'textarea',
                  id: 'command',
                  label: linkLang.commandText,
                  required: true,
                  validate: function()
                  {
                    var dialog = this.getDialog();

                    var linkType = this.getDialog().getContentElement('info', 'linkType');
                    if (!linkType || (linkType != 'suggestcommand' && linkType != 'runcommand'))
                    {
                      return true;
                    }

                    var func = CKEDITOR.dialog.validate.notEmpty(linkLang.commandNoText);
                    return func.apply(this);
                  },
                  setup: function(data)
                  {
                    if (data.command)
                      this.setValue(data.command.text);

                    var linkType = this.getDialog().getContentElement('info', 'linkType');
                    if (linkType && (linkType.getValue() == 'suggestcommand' || linkType.getValue() == 'runcommand'))
                      this.select();
                  },
                  commit: function(data)
                  {
                    if (!data.command)
                      data.command = {};

                    data.command.text = this.getValue();
                  }
                },
                {
                  type: 'html',
                  html: '<div class="info">' + linkLang.commandLengthBug + '</div>',
                }
              ],
              setup: function()
              {
                if (!this.getDialog().getContentElement('info', 'linkType'))
                  this.getElement().hide();
              }
            },
            { // zone "changepage"
              type: 'vbox',
              id: 'changepageOptions',
              padding: 1,
              children:
              [
                {
                  type: 'text',
                  id: 'changepage',
                  label: linkLang.pageText,
                  required: true,
                  validate: function()
                  {
                    var dialog = this.getDialog();

                    if (!dialog.getContentElement('info', 'linkType') || dialog.getValueOf('info', 'linkType') != 'changepage')
                      return true;

                    var func = CKEDITOR.dialog.validate.notEmpty(linkLang.insertNoText);
                    return func.apply(this);
                  },
                  setup: function(data)
                  {
                    if (data.changepage)
                      this.setValue(data.changepage.page);

                    var linkType = this.getDialog().getContentElement('info', 'linkType');
                    if (linkType && linkType.getValue() == 'changepage')
                      this.select();
                  },
                  commit: function(data)
                  {
                    if (!data.changepage)
                      data.changepage = {};

                    data.changepage.page = this.getValue();
                  }
                },
                {
                  type: 'html',
                  html: '<div class="info">' + linkLang.typeChangepageInfos + '</div>',
                }
              ],
              setup: function()
              {
                if ( !this.getDialog().getContentElement( 'info', 'linkType' ) )
                  this.getElement().hide();
              }
            },
          ]
        }
      ],
      onShow: function()
      {
        var editor = this.getParentEditor(),
          selection = editor.getSelection(),
          element = null;

        // Fill in all the relevant fields if there's already one link selected.
        if ((element = plugin.getSelectedLink(editor)) && element.hasAttribute('href'))
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

        var data = plugin.parseLinkAttributes(editor, element);

        // Record down the selected element in the dialog.
        this._.selectedElement = element;

        this.setupContent(data);
      },
      onOk: function()
      {
        var data = {};

        // Collect data from fields.
        this.commitContent(data);

        var selection = editor.getSelection();
        var attributes = plugin.getLinkAttributes(editor, data);

        if (!this._.selectedElement)
        {
          // Si ajout d'un nouvel element
          var range = selection.getRanges()[0];

          // Use link URL as text with a collapsed cursor.
          if (range.collapsed) // aucune selection, uniquement un curseur
          {
            range.enlarge(CKEDITOR.ENLARGE_BLOCK_CONTENTS); // selectionne tout le contenu
          }

          // Apply style.
          var style = new CKEDITOR.style(
          {
            element: 'a',
            attributes: attributes.set
          });

          style.type = CKEDITOR.STYLE_INLINE; // need to override... dunno why.
          style.applyToRange( range, editor );
          range.select();
        }
        else
        {
          // We're only editing an existing link, so just overwrite the attributes.
          var element = this._.selectedElement,
            href = element.data( 'cke-saved-href' ),
            textView = element.getHtml();

          element.setAttributes(attributes.set);
          element.removeAttributes(attributes.removed);

          delete this._.selectedElement;
        }
      },
      
      onLoad: function()
      {
      },
      
      // Inital focus on 'url' field if link is of type URL.
      onFocus: function()
      {
        var linkType = this.getContentElement('info', 'linkType'),
          urlField;

        if (linkType && linkType.getValue() == 'openurl')
        {
          urlField = this.getContentElement('info', 'url');
          urlField.select();
        }
      }
    };
  });
})();
