function bindData(el, binding, vNode, oldVnode) {
    let container = el.querySelector('.who-rated');
    if(container) {
        container.remove();
    }
    
    if(binding.value.length === 0) {
        return;
    }
    
    let who  = binding.value.join(', ');
    let html = `
        <div class="who-rated">
            ${who}
        </div>
        `;
    
    let positions = [
        'relative',
        'absolute',
    ];
    if(!positions.includes(el.style.position)) {
        el.style.position = 'relative';
    }
    el.insertAdjacentHTML('beforeend', html);
};

export default {
    /**
     * @param {HTMLElement} el
     * @param {Object} binding
     * @param {Object} vNode
     * @param {Object} oldVnode
     */
    inserted: bindData,
    bind:     bindData,
    update:   bindData,
};