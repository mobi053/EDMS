import "./polyfills";
import React from "react";
import { createRoot } from 'react-dom/client';

import * as serviceWorker from "./serviceWorker";

import { HashRouter } from "react-router-dom";
import "./assets/base.scss";
import Main from "./DemoPages/Main";
import configureStore from "./config/configureStore";
import { Provider } from "react-redux";
import 'primereact/resources/themes/saga-blue/theme.css';  // Choose your desired theme
import 'primereact/resources/primereact.min.css';          // Core styles
import 'primeicons/primeicons.css';                         // PrimeIcons


const store = configureStore();
const rootElement = document.getElementById("root");

const renderApp = (Component) => (
  <Provider store={store}>
    <HashRouter>
      <Component />
    </HashRouter>
  </Provider>
);

const root = createRoot(rootElement).render(renderApp(Main));

if (module.hot) {
  module.hot.accept("./DemoPages/Main", () => {
    const NextApp = require("./DemoPages/Main").default;
    root.render(renderApp(NextApp));
  });
}
serviceWorker.unregister();