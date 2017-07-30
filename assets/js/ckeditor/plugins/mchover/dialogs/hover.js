/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

'use strict';

(function()
{
  CKEDITOR.dialog.add('mchover', function(editor)
  {
    var plugin = CKEDITOR.plugins.mchover;

    // Handles the event when the "Type" selection box is changed.
    var hoverTypeChanged = function()
    {
      var dialog = this.getDialog(),
        partIds = [ 'textOptions', 'itemOptions', 'entityOptions', 'achievementOptions', 'statisticOptions' ],
        typeValue = this.getValue();

      // affichage des options correspondantes en fonction du type selectionné
      for (var i = 0; i < partIds.length; i++)
      {
        var element = dialog.getContentElement('info', partIds[i]);
        if (!element)
          continue;

        element = element.getElement().getParent().getParent();
        if (partIds[i] == 'textOptions')
        {
          if (typeValue == 'text')
            element.show();
          else
            element.hide();
        }
        else if (partIds[i] == 'itemOptions')
        {
          if (typeValue == 'item')
            element.show();
          else
            element.hide();
        }
        else if (partIds[i] == 'entityOptions')
        {
          if (typeValue == 'entity')
            element.show();
          else
            element.hide();
        }
        else if (partIds[i] == 'achievementOptions')
        {
          if (typeValue == 'achievement')
            element.show();
          else
            element.hide();
        }
        else if (partIds[i] == 'statisticOptions')
        {
          if (typeValue == 'statistic')
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
    var hoverLang = editor.lang.mchover;

    // définition de la popup
    return {
      title: hoverLang.title,
      minWidth: 350,
      minHeight: 230,
      contents:
      [
        {
          id: 'info',
          //requiredContent: 'a[target]', // This is not fully correct, because some target option requires JS.
          label: hoverLang.title,
          title: hoverLang.title,
          elements:
          [
            { // Type de lien
              id: 'hoverType',
              type: 'select',
              label: hoverLang.type,
              'default': 'text',
              items: [
                [ hoverLang.selectText, 'text' ],
                [ hoverLang.selectItem, 'item' ],
                [ hoverLang.selectEntity, 'entity' ],
                [ hoverLang.selectAchievement, 'achievement' ],
                [ hoverLang.selectStatistic, 'statistic' ],
              ],
              onChange: hoverTypeChanged,
              setup: function(data)
              {
                this.setValue(data.type || 'text');
              },
              commit: function(data)
              {
                data.type = this.getValue();
              }
            },
            { // zone "text"
              type: 'vbox',
              id: 'textOptions',
              children:
              [
                {
                  type: 'textarea',
                  id: 'text',
                  label: hoverLang.textTitle,
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

                    if (dialog.getContentElement('info', 'hoverType') && dialog.getValueOf('info', 'hoverType') != 'text')
                      return true;

                    var func = CKEDITOR.dialog.validate.notEmpty(hoverLang.noText);
                    return func.apply(this);
                  },
                  setup: function(data)
                  {
                    this.allowOnChange = false;
                    this.setValue(data.text);
                    this.allowOnChange = true;
                  },
                  commit: function(data)
                  {
                    // IE will not trigger the onChange event if the mouse has been used
                    // to carry all the operations #4724
                    this.onChange();

                    data.text = this.getValue();
                    this.allowOnChange = false;
                  }
                },
                {
                  type: 'html',
                  html: '<div class="info">' + hoverLang.textExtraInfos + '</div>',
                }
              ]
            },
            { // zone "item"
              type: 'vbox',
              id: 'itemOptions',
              padding: 1,
              children:
              [
                {
                  type: 'textarea',
                  id: 'item',
                  label: hoverLang.itemTitle,
                  required: true,
                  validate: function()
                  {
                    var dialog = this.getDialog();

                    if (!dialog.getContentElement('info', 'hoverType') || dialog.getValueOf('info', 'hoverType') != 'item')
                      return true;

                    var func = CKEDITOR.dialog.validate.notEmpty(hoverLang.noItem);
                    return func.apply(this);
                  },
                  setup: function(data)
                  {
                    this.setValue(data.item);

                    var hoverType = this.getDialog().getContentElement('info', 'hoverType');
                    if (hoverType && hoverType.getValue() == 'item')
                      this.select();
                  },
                  commit: function(data)
                  {
                    data.item = this.getValue();
                  }
                },
                {
                  type: 'html',
                  html: '<div class="info"><strong>' + hoverLang.example + ':</strong><br/>'
                  + 'cake<br/>'
                  + '{id:cake,tag:{display:{Name:"A Cake",Lore:["Made by","Steve & Alex","With Love <3"]}}}</div>',
                }
              ],
              setup: function()
              {
                if ( !this.getDialog().getContentElement( 'info', 'hoverType' ) )
                  this.getElement().hide();
              }
            },
            { // zone "entity*"
              type: 'vbox',
              id: 'entityOptions',
              padding: 1,
              children:
              [
                {
                  type: 'text',
                  id: 'entity_type',
                  label: hoverLang.entityTypeTitle,
                  required: true,
                  validate: function()
                  {
                    var dialog = this.getDialog();

                    if (!dialog.getContentElement('info', 'hoverType') || dialog.getValueOf('info', 'hoverType') != 'entity')
                      return true;

                    //var func = CKEDITOR.dialog.validate.notEmpty(hoverLang.commandNoText);
                    return true; //func.apply(this);
                  },
                  setup: function(data)
                  {
                    if (data.entity)
                      this.setValue(data.entity.type);

                    var hoverType = this.getDialog().getContentElement('info', 'hoverType');
                    if (hoverType && hoverType.getValue() == 'entity')
                      this.select();
                  },
                  commit: function(data)
                  {
                    if (!data.entity)
                      data.entity = {};

                    data.entity.type = this.getValue();
                  }
                },
                {
                  type: 'text',
                  id: 'entity_name',
                  label: hoverLang.entityNameTitle,
                  required: true,
                  validate: function()
                  {
                    var dialog = this.getDialog();

                    if (!dialog.getContentElement('info', 'hoverType') || dialog.getValueOf('info', 'hoverType') != 'entity')
                      return true;

                    //var func = CKEDITOR.dialog.validate.notEmpty(hoverLang.commandNoText);
                    return true; //func.apply(this);
                  },
                  setup: function(data)
                  {
                    if (data.entity)
                      this.setValue(data.entity.name);

                    var hoverType = this.getDialog().getContentElement('info', 'hoverType');
                    if (hoverType && hoverType.getValue() == 'entity')
                      this.select();
                  },
                  commit: function(data)
                  {
                    if (!data.entity)
                      data.entity = {};

                    data.entity.name = this.getValue();
                  }
                },
                {
                  type: 'text',
                  id: 'entity_id',
                  label: hoverLang.entityIdTitle,
                  required: true,
                  validate: function()
                  {
                    var dialog = this.getDialog();

                    if (!dialog.getContentElement('info', 'hoverType') || dialog.getValueOf('info', 'hoverType') != 'entity')
                      return true;

                    //var func = CKEDITOR.dialog.validate.notEmpty(hoverLang.commandNoText);
                    return true; //func.apply(this);
                  },
                  setup: function(data)
                  {
                    if (data.entity)
                      this.setValue(data.entity.id);

                    var hoverType = this.getDialog().getContentElement('info', 'hoverType');
                    if (hoverType && hoverType.getValue() == 'entity')
                      this.select();
                  },
                  commit: function(data)
                  {
                    if (!data.entity)
                      data.entity = {};

                    data.entity.id = this.getValue();
                  }
                },
              ],
              setup: function()
              {
                if (!this.getDialog().getContentElement('info', 'hoverType'))
                  this.getElement().hide();
              }
            },
            { // zone "achievement"
              type: 'vbox',
              id: 'achievementOptions',
              padding: 1,
              children:
              [
                {
                  type: 'text',
                  id: 'achievement',
                  label: hoverLang.achievementTitle,
                  required: true,
                  validate: function()
                  {
                    var dialog = this.getDialog();

                    if (!dialog.getContentElement('info', 'hoverType') || dialog.getValueOf('info', 'hoverType') != 'achievement')
                      return true;

                    var func = CKEDITOR.dialog.validate.notEmpty(hoverLang.noAchievement);
                    return func.apply(this);
                  },
                  setup: function(data)
                  {
                    this.setValue(data.achievement);

                    var hoverType = this.getDialog().getContentElement('info', 'hoverType');
                    if (hoverType && hoverType.getValue() == 'achievement')
                      this.select();
                  },
                  commit: function(data)
                  {
                    data.achievement = this.getValue();
                  }
                },
                {
                  type: 'html',
                  html: '<div class="info"><strong>' + hoverLang.example + ':</strong> theEnd2</div>',
                }
              ],
              setup: function()
              {
                if ( !this.getDialog().getContentElement( 'info', 'hoverType' ) )
                  this.getElement().hide();
              }
            },
            { // zone "statistic"
              type: 'vbox',
              id: 'statisticOptions',
              padding: 1,
              children:
              [
                {
                  type: 'text',
                  id: 'statistic',
                  label: hoverLang.statisticTitle,
                  required: true,
                  validate: function()
                  {
                    var dialog = this.getDialog();

                    if (!dialog.getContentElement('info', 'hoverType') || dialog.getValueOf('info', 'hoverType') != 'statistic')
                      return true;

                    var func = CKEDITOR.dialog.validate.notEmpty(hoverLang.nostatistic);
                    return func.apply(this);
                  },
                  setup: function(data)
                  {
                    this.setValue(data.statistic);

                    var hoverType = this.getDialog().getContentElement('info', 'hoverType');
                    if (hoverType && hoverType.getValue() == 'statistic')
                      this.select();
                  },
                  commit: function(data)
                  {
                    data.statistic = this.getValue();
                  }
                },
                {
                  type: 'html',
                  html: '<div class="info"><strong>' + hoverLang.example + ':</strong> damageDealt</div>',
                }
              ],
              setup: function()
              {
                if ( !this.getDialog().getContentElement( 'info', 'hoverType' ) )
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
        if (element = plugin.getSelectedHover(editor))
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

        var data = plugin.parseHoverAttributes(editor, element);

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
        var attributes = plugin.getHoverAttributes(editor, data);

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
            element: 'ins',
            attributes: attributes.set
          });

          style.type = CKEDITOR.STYLE_INLINE; // need to override... dunno why.
          style.applyToRange( range, editor );
          range.select();
        }
        else
        {
          // We're only editing an existing link, so just overwrite the attributes.
          var element = this._.selectedElement;

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
        var hoverType = this.getContentElement('info', 'hoverType'),
          textField;

        if (hoverType && hoverType.getValue() == 'text')
        {
          textField = this.getContentElement('info', 'text');
          textField.select();
        }
      }
    };
  });
})();
