import {Controller} from '@hotwired/stimulus';

export default class extends Controller {


  constructor(context) {
    super(context);
    this.img = document.querySelector("[preview='form-publication-img']");

  }

  connect() {
    this.element.addEventListener('dropzone:connect', this._onConnect);
    this.element.addEventListener('dropzone:change', this._onChange);
    this.element.addEventListener('dropzone:clear', this._onClear);
  }

  disconnect() {
    this.element.removeEventListener('dropzone:connect', this._onConnect);
    this.element.removeEventListener('dropzone:change', this._onChange);
    this.element.removeEventListener('dropzone:clear', this._onClear);
  }

  _onConnect(event) {
    // The dropzone was just created
  }

  _onChange(event) {
    let srcElement = event.srcElement
    let image = srcElement.querySelector(".dropzone-preview-image").style
    event.detail.stream().getReader().read().then(({done, value}) => {
      let img = btoa(
        Array(value.length)
          .fill('')
          .map((_, i) => String.fromCharCode(value[i]))
          .join('')
      )
      image = "data:image/png;base64," + img
      const preview = document.querySelector("#preview");
      const previewImage = preview.querySelector("#preview-img");
      const emptyImage = preview.querySelector("#empty-image");
      emptyImage.style.display = "none";
      previewImage.src = image;
    })

  }

  _onClear(event) {
    const preview = document.querySelector("#preview");
    const previewImage = preview.querySelector("#preview-img");
    const emptyImage = preview.querySelector("#empty-image");
    emptyImage.style.display = "block";
    previewImage.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAQAAACWCLlpAAAA3klEQVR42u3QQREAAAwCoNm/9Cr49iACOWpRIEuWLFmyZCmQJUuWLFmyFMiSJUuWLFkKZMmSJUuWLAWyZMmSJUuWAlmyZMmSJUuBLFmyZMmSpUCWLFmyZMlSIEuWLFmyZCmQJUuWLFmyFMiSJUuWLFkKZMmSJUuWLAWyZMmSJUuWAlmyZMmSJUuBLFmyZMmSpUCWLFmyZMlSIEuWLFmyZCmQJUuWLFmyFMiSJUuWLFkKZMmSJUuWLAWyZMmSJUuWAlmyZMmSJUuBLFmyZMmSpUCWLFmyZMlSIEuWLFmbHrcjAJdeLWiCAAAAAElFTkSuQmCC";
  }

}
