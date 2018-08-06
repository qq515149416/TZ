import React from "react";
import ListTableComponent from "../component/listTableComponent.jsx";
import { inject,observer } from "mobx-react";
@inject("usersLinkInfoStores")
@observer 
class UsersLinkList extends React.Component {
  componentDidMount() {
    this.props.usersLinkInfoStores.getData();
  }
  addData = (param,callbrak) => {
    this.props.usersLinkInfoStores.addData(param).then((state) => {
          callbrak(state);
    });
  }
  delData = (selectedData,callbrak) => {
    const {usersLinkInfoStores} = this.props;
    let delIng = selectedData.map(item => usersLinkInfoStores.delData(item));
    callbrak(delIng);
  }
  render() {
    return (
      <ListTableComponent data={this.props.usersLinkInfoStores.user} addData={this.addData.bind(this)} delData={this.delData.bind(this)}  />
    );
  }
}
export default UsersLinkList;