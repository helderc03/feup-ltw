const draggables = document.querySelectorAll('.ticket')
const containers = document.querySelectorAll('.container')
const toggleButton = document.querySelector('.menu-btn');
const menu = document.querySelector('.sidenav-menu');

toggleButton.addEventListener('click', () => {
  const expanded = toggleButton.getAttribute('aria-expanded') === 'true' || false;
  toggleButton.setAttribute('aria-expanded', !expanded);
  menu.classList.toggle('show');
  toggleButton.classList.toggle('opened', !expanded);
});

draggables.forEach(draggable => {
    draggable.addEventListener('dragstart', () => {
        draggable.classList.add('dragging')
    })

    draggable.addEventListener('dragend', () => {
        draggable.classList.remove('dragging')
    })
})

containers.forEach(container => {
    container.addEventListener('dragover', e => {
        e.preventDefault()
        const afterElement = getDragAfterElement(container, e.clientY)
        const draggable = document.querySelector('.dragging')
        if(afterElement == null){
            container.appendChild(draggable)
        } else{
            container.insertBefore(draggable, afterElement)
        }
    })
})

function getDragAfterElement(container, y){
    const draggableElements = [...container.querySelectorAll('.ticket:not(.dragging)')]

    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect()
        const offset = y - box.top - box.height / 2
        if(offset < 0 && offset > closest.offset){
            return {offset: offset, element: child}
        } else{
            return closest;
        }
    }, {offset: Number.NEGATIVE_INFINITY}).element

}