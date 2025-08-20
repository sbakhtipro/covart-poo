import Home from "./components/Home"
import Lost from "./components/Lost"
import Error404 from "./components/Error404"

const root = document.getElementById('root')

let path = window.location.pathname

if (path === '/') {
    root.appendChild(Home())
}
else if (path === '/lost') {
    root.appendChild(Lost())
}
else {
    root.appendChild(Error404())
}