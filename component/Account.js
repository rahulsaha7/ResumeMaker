import React, { Component } from 'react'
import { Text, View } from 'react-native'

import SignIn from './SignIn'
import SignUp from './SignUp'

export class Account extends Component {
    constructor(props) {
        super(props)
    
        this.state = {
             showSignInPage: true
        }
    }

    openSignUpPage = ()=>{
        this.setState({
            showSignInPage: false,
        })
    }

    openSignInPage = ()=>{
        this.setState({
            showSignInPage: true,
        })
    }
    
    /**
     * custom validation rules to validate form
     */
/*
    customValidationRules = {
        name: /^[a-zA-Z-' ]*$/
    }
*/
    render() {
        return (
                this.state.showSignInPage?
                <SignIn openSignUpPage={this.openSignUpPage} isConnected={this.props.isConnected} changeState={this.props.changeState}/>
                :
                <SignUp
                    openSignInPage={this.openSignInPage}
                    isConnected={this.props.isConnected} // containing if network is connected or not
                    changeState={this.props.changeState} // function to change login state
                    />
        )
    }
}

export default Account
