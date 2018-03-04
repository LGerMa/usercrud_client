document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] +
  ':35729/livereload.js?snipver=1"></' + 'script>')

const app = new Vue({
	el: "#app",
	data: {
		name: "bobby",
		age: 27
	},
	template: `
		<div>
			<h2>{{ name }}</h2>
			<h2>{{ age }}</h2>
		</div>
	`
})