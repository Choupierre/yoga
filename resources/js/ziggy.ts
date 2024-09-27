const Ziggy = {"url":"http:\/\/yoga.test","port":null,"defaults":{},"routes":{"debugbar.openhandler":{"uri":"_debugbar\/open","methods":["GET","HEAD"]},"debugbar.clockwork":{"uri":"_debugbar\/clockwork\/{id}","methods":["GET","HEAD"],"parameters":["id"]},"debugbar.assets.css":{"uri":"_debugbar\/assets\/stylesheets","methods":["GET","HEAD"]},"debugbar.assets.js":{"uri":"_debugbar\/assets\/javascript","methods":["GET","HEAD"]},"debugbar.cache.delete":{"uri":"_debugbar\/cache\/{key}\/{tags?}","methods":["DELETE"],"parameters":["key","tags"]},"debugbar.queries.explain":{"uri":"_debugbar\/queries\/explain","methods":["POST"]},"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"dates.index":{"uri":"api\/dates","methods":["GET","HEAD"]},"dates.store":{"uri":"api\/dates","methods":["POST"]},"dates.show":{"uri":"api\/dates\/{date}","methods":["GET","HEAD"],"parameters":["date"]},"dates.update":{"uri":"api\/dates\/{date}","methods":["PUT","PATCH"],"parameters":["date"],"bindings":{"date":"id"}},"dates.destroy":{"uri":"api\/dates\/{date}","methods":["DELETE"],"parameters":["date"],"bindings":{"date":"id"}},"users.index":{"uri":"api\/users","methods":["GET","HEAD"]},"users.store":{"uri":"api\/users","methods":["POST"]},"users.show":{"uri":"api\/users\/{user}","methods":["GET","HEAD"],"parameters":["user"],"bindings":{"user":"id"}},"users.update":{"uri":"api\/users\/{user}","methods":["PUT","PATCH"],"parameters":["user"],"bindings":{"user":"id"}},"users.destroy":{"uri":"api\/users\/{user}","methods":["DELETE"],"parameters":["user"],"bindings":{"user":"id"}},"home":{"uri":"\/","methods":["GET","HEAD"]},"register":{"uri":"register","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["GET","HEAD"]},"password.request":{"uri":"forgot-password","methods":["GET","HEAD"]},"password.email":{"uri":"forgot-password","methods":["POST"]},"password.reset":{"uri":"reset-password\/{token}","methods":["GET","HEAD"],"parameters":["token"]},"password.update":{"uri":"reset-password","methods":["POST"]},"logout":{"uri":"logout","methods":["POST"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };