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
  {
    field: "tid",
    label: "文章分类",
    type: "select",
    defaultData: []
  },
  {
    field: "title",
    label: "标题",
    type: "text"
  },
  {
    field: "digest",
    label: "摘要",
    type: "text"
  },
  {
    field: "top_status",
    label: "置顶状态",
    type: "switch",
    radioData: [
      {
        checked: true,
        value: "0",
        label: "不显示"
      },
      {
        checked: false,
        value: "1",
        label: "显示"
      }
    ],
    model: {
      selectCode: (data) => {
        switch(data) {
          case "不显示":
              return 0;
          case "显示":
              return 1;
        }
      }
    }
  },
  {
    field: "home_status",
    label: "首页显示状态",
    type: "switch",
    radioData: [
      {
        checked: true,
        value: "0",
        label: "不显示"
      },
      {
        checked: false,
        value: "1",
        label: "显示"
      }
    ],
    model: {
      selectCode: (data) => {
        switch(data) {
          case "不显示":
              return 0;
          case "显示":
              return 1;
        }
      }
    }
  },
  {
    field: "seoKeywords",
    label: "seo关键词",
    type: "text"
  },
  {
    field: "seoTitle",
    label: "seo标题",
    type: "text"
  },
  {
    field: "seoDescription",
    label: "seo描述",
    type: "text"
  },
  {
    field: "content",
    label: "内容",
    type: "rich_text"
  }
];
@inject("newsStores")
@observer 
class NewList extends React.Component {
  componentDidMount() {
    this.props.newsStores.getData();
  }
  addData = (param,callbrak) => {
    // console.log(param);
    this.props.newsStores.addData(param).then((state) => {
      callbrak(state);
    });
  }
  render() {
    inputType[inputType.findIndex(item => item.field=="tid")].defaultData = this.props.newsStores.types.map(item => {
      return {
        value: item.tid,
        text: item.type_name
      }
    });
    return (
      <ListTableComponent 
        title="文章管理"
        operattext="文章"
        inputType={inputType} 
        headTitlesData={columnData} 
        data={this.props.newsStores.articles}
        addData={this.addData.bind(this)} 
      />
    );
  }
}
export default NewList;