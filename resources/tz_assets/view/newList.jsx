import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";

const columnData = [
    { id: 'title', numeric: true, disablePadding: false, label: '标题' },
    { id: 'type_name.name', numeric: true, disablePadding: false, label: '文章类型' },
    { id: 'top_status', numeric: true, disablePadding: false, label: '是否置顶显示' },
    { id: 'home_status', numeric: true, disablePadding: false, label: '是否首页显示' },
    { id: 'seoKeywords', numeric: true, disablePadding: false, label: 'seo关键词' },
    { id: 'operat', numeric: true, disablePadding: false, extend: true, extendData: [
        "title",
        "digest",
        "content"
    ], label: '操作' },
];
const inputType = [
];
@inject("newsStores")
@observer 
class NewList extends React.Component {
  componentDidMount() {
    this.props.newsStores.getData();
  }
  render() {
    return (
      <ListTableComponent 
        title="文章管理"
        operattext="文章"
        inputType={inputType} 
        headTitlesData={columnData} 
        data={this.props.newsStores.articles}
      />
    );
  }
}
export default NewList;