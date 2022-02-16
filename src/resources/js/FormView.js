'use strict';

var Nodus = Nodus || {};

Nodus.FormView = class {
    /**
     * Form view constructor
     *
     * @param form
     */
    constructor(form) {
        if (typeof form === 'string') {
            form = document.querySelector(form);
        }

        this.form = form;
    }

    init() {
        console.log('INIT FORM');

        // Initial render form initializing
        document.addEventListener('livewire:load', function() {
            this.initInputs(true);
        }.bind(this));

        // On livewire update -> reinitializing the inputs
        Livewire.hook('message.processed', function() {
            this.initInputs(false);
        }.bind(this));

        // On livewire DOM update destroy bootstrap selects
        Livewire.hook('element.updating', (fromEl, toEl, component) => {
            if (!fromEl.classList.contains('nodus-form-control-select')) {
                return;
            }

            const select = fromEl.querySelector('select');

            if (select === null || fromEl.getAttribute('data-init') !== 'true') {
                return;
            }

            $(select).selectpicker('destroy');
        });
    }

    getRelevantInputClasses() {
        const classes = [
            '.nodus-form-control-select',
            '.nodus-form-control-decimal',
            '.nodus-form-control-code',
            '.nodus-form-control-richtextarea',
        ]

        return classes.join(', ');
    }

    initInputs(initialRender = true) {
        this.livewireId = this.form.getAttribute('wire:id');
        this.livewire = window.livewire.find(this.livewireId);

        this.form.querySelectorAll(this.getRelevantInputClasses()).forEach(function(container) {
            if (container.hasAttribute('data-init') && container.getAttribute('data-init') === 'true') {
                console.log('Already initialized', container);
                return;
            }

            console.log('Init form control: ', container);

            if (container.classList.contains('nodus-form-control-select')) {
                this.initSelect(container);
            } else if (container.classList.contains('nodus-form-control-decimal')) {
                this.initDecimal(container);
            } else if (container.classList.contains('nodus-form-control-code')) {
                this.initCode(container);
            } else if (container.classList.contains('nodus-form-control-richtextarea') && initialRender === true) {
                this.initRichtextArea(container);
            }

            container.setAttribute('data-init', 'true');
        }.bind(this));
    }

    initCode(container) {
        const id = container.getAttribute('data-id');
        const element = document.querySelector('#' + id);
        const input = document.querySelector('#' + id + '_text');

        const editor = CodeMirror.fromTextArea(element, {
            mode: container.getAttribute('data-mode'),
            lineNumbers: true,
            indentUnit: 4,
        });

        editor.setOption("extraKeys", {
            Tab: function(cm) {
                var spaces = Array(cm.getOption("indentUnit") + 1).join(" ");
                cm.replaceSelection(spaces);
            }
        });

        editor.on("change", function() {
            input.dispatchEvent(new CustomEvent('input', {
                detail: editor.getValue(),
                bubbles: true,
            }));
        });
    }

    initDecimal(container) {
        new Nodus.DecimalInput(container.querySelector('.form-control'))
    }

    initRichtextArea(container) {
        const id = container.getAttribute('data-id');
        const element = document.querySelector('#' + id);
        const input = document.querySelector('#' + id + '_text');

        const editor = new Quill(element, {
            theme: 'snow'
        });

        editor.on('text-change', function() {
            input.dispatchEvent(new CustomEvent('input', {
                detail: editor.root.innerHTML,
                bubbles: true,
            }));
        });

        editor.on('selection-change', function(range, oldRange, source) {
            if ((range === null && oldRange !== null) || (range === null && oldRange === undefined)) {
                this.livewire.set('values.' + id, editor.root.innerHTML);
            }
        }.bind(this));
    }

    initSelect(container) {
        const id = container.getAttribute('data-id');
        const input = $('#' + id);

        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
            input.selectpicker('mobile');
        } else {
            input.selectpicker();
        }
    }
};
