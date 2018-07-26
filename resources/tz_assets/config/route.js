/**
 * @augments ReactDOM 用来渲染react对象
 * @augments renderComponents 渲染列表
 * @augments itemRoute 当前渲染名称
 */
export default (ReactDOM,renderComponents,itemRoute) => {
    renderComponents.forEach((item) => {
        if(renderComponents.itemRoute == itemRoute) {
            ReactDOM.render(renderComponents.itemRoute,renderComponents.routeDOM);
        }
    });
}