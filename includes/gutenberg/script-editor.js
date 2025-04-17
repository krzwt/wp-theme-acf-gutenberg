document.addEventListener('DOMContentLoaded', function () {
    // Function to initialize the collapse button and block list
    function initializeCollapseButton() {
        const blocklayout = document.querySelector('.is-root-container.block-editor-block-list__layout');

        if (blocklayout) {
            // Create and insert the collapse button
            const blockList = blocklayout.querySelectorAll('[class*="wp-block-acf-"]');

            if (blockList.length > 0) {
                // Remove existing button to avoid duplicates
                const existingButtonContainer = document.querySelector('.collapse-button-container');
                if (existingButtonContainer) {
                    existingButtonContainer.remove();
                }

                const buttonContainer = document.createElement('div');
                buttonContainer.className = 'collapse-button-container wp-block';

                const collapseButton = document.createElement('button');
                collapseButton.className = 'collapse-button components-button is-primary';
                collapseButton.innerText = 'Collapse All';
                buttonContainer.appendChild(collapseButton);

                blocklayout.prepend(buttonContainer);

                // Update the accordion state and titles
                updateAccordionState(blockList);
                updateAccordionTitles(blockList);

                // Add click functionality to the collapse button
                collapseButton.addEventListener('click', function (event) {
                    event.preventDefault();
                    toggleAccordionState(blockList);
                });
            }
        }
    }

    // Initialize collapse button on page load
    setTimeout(initializeCollapseButton, 100);

    // Re-initialize collapse button on block add/remove
    wp.data.subscribe(function () {
        const blocks = wp.data.select('core/block-editor').getBlocks();
        initializeCollapseButton();
    });
});

/**
 * Updates the state of each accordion block.
 * @param {NodeList} blockList - List of blocks.
 */
function updateAccordionState(blockList) {
    blockList.forEach(block => {
        const accContent = block.querySelector('.acf-accordion-content');
        const toggle = block.querySelector('.acf-field-accordion');

        if (accContent && window.getComputedStyle(accContent).display !== 'none') {
            if (toggle) {
                toggle.classList.add('-open');
            } else {
                block.classList.add('-open');
            }
        } else {
            if (toggle) {
                toggle.classList.remove('-open');
            } else {
                block.classList.remove('-open');
            }
        }
    });
}

/**
 * Toggles the state of each accordion block.
 * @param {NodeList} blockList - List of blocks.
 */
function toggleAccordionState(blockList) {
    blockList.forEach(block => {
        const accElements = block.querySelectorAll('.acf-field-accordion');

        accElements.forEach(acc => {
            if (acc.classList.contains('-open')) {
                const accTitle = acc.querySelector('.acf-accordion-title');
                if (accTitle) {
                    accTitle.click();
                }
            }
        });
    });
}

/**
 * Updates the accordion titles with data-title attributes.
 * @param {NodeList} blockList - List of blocks.
 */
function updateAccordionTitles(blockList) {
    blockList.forEach(block => {
        const dataTitle = block.getAttribute('data-title');
        const accLabel = block.querySelector('.acf-field-accordion .acf-accordion-title label');
        if (accLabel && dataTitle) {
            accLabel.innerText = dataTitle;
        }
    });
}

// ACF fields move below the post title in Gutenberg.
document.addEventListener('DOMContentLoaded', function () {
    function moveACFFields() {
        const postTitle = document.querySelector('.editor-visual-editor__post-title-wrapper');
        const acfFieldGroup = document.querySelector('.edit-post-layout__metaboxes .edit-post-meta-boxes-area');

        if (acfFieldGroup && acfFieldGroup.querySelector('.postbox.acf-postbox')) {
            // Create a new wrapper div with a specific class name
            const wrapperDiv = document.createElement('div');
            wrapperDiv.classList.add('edit-post-layout__metaboxes'); // Add your desired class

            // Append the ACF fields into the new wrapper div
            wrapperDiv.appendChild(acfFieldGroup);
            // Move the ACF fields below the post title
            postTitle.parentNode.insertBefore(wrapperDiv, postTitle.nextSibling);

            // Add a delay to ensure everything is fully loaded before reinitializing
            setTimeout(function () {
                if (typeof acf !== 'undefined' && typeof tinymce !== 'undefined') {
                    // Reinitialize all TinyMCE editors
                    acf.getFields({
                        type: 'wysiwyg'
                    }).forEach(function (field) {
                        var id = field.$el.find('textarea').attr('id');
                        var editor = tinymce.get(id);
                        if (editor) {
                            editor.remove();
                            tinymce.init(tinyMCEPreInit.mceInit[id]);
                        }
                    });

                    // Refresh ACF layout
                    acf.doAction('refresh');
                }
            }, 1500); // Increased delay to 1500ms
        } else {
            console.info('ACF fields not found or not in the expected container.');
        }
    }

    // Check if Gutenberg editor is fully loaded
    const checkEditorLoaded = setInterval(function () {
        const postTitle = document.querySelector('.editor-visual-editor__post-title-wrapper');
        if (postTitle) {
            clearInterval(checkEditorLoaded);
            moveACFFields();
        }
    }, 600);
});