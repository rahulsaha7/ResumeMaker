import React, { Component } from 'react'
import { Text, View, StyleSheet, Image, Alert, Pressable, KeyboardAvoidingView, Platform, ScrollView } from 'react-native'
//import {} from 'react-native-paper'
import { LinearGradient } from 'expo-linear-gradient';
import { TextInput, Button } from 'react-native-paper';
import MaterialIcons from 'react-native-vector-icons/MaterialIcons';
import { withTheme } from 'react-native-paper';
import ValidationComponent from 'react-native-form-validator';
import AwesomeAlert from 'react-native-awesome-alerts';
import axios from 'axios';
import qs from 'qs'
import jwt_decode from "jwt-decode";

import { ERContext } from '../ERContext';
import { HOST } from './config'

class SignIn extends ValidationComponent {
    constructor(props) {
        super(props);
        this.state = {
            otp:'',
            username:'',
            password:'',
            showAlert: false,
            showModalProgress:false,
            modalTitle:'',
            modalMessage:'',
            closeOnTouchOutside:false,
            showConfirmButton:false,
            confirmText:'',
            onConfirmPressed:()=>this.hideAlert(),

            usernameError:false,
            passwordError:false,
            showLoginPage: true,
            showForgotPasswordPage:false,
            showVerifyOtpPage:false,
            showUpdatePasswordPage:false,
        }
    }
    showAlert = () => {
        this.setState({
          showAlert: true
        });
      };

    hideAlert = () => {
        this.setState({
          showAlert: false
        });
      };

    _onChangeUsername =  (value)=>{
        this.setState({
            username:value,
        },()=>{
            this.validate({
                username:{email:true,required: true},
            });
            this.setState({
                usernameError:this.isFieldInError('username'),
            });
        });
    }
    _onChangePassword =  (value)=>{
        this.setState({
            password:value,
        },()=>{
            this.validate({
                password:{minlength:5, maxlength:20, required: true}
            });
            this.setState({
                passwordError:this.isFieldInError('password'),
            });
        });
    }

    _onSubmit = async() => {

        this.validate({
            username:{email:true,required: true},
            password:{minlength:5, maxlength:20, required: true}
        });
        this.setState({
            usernameError:this.isFieldInError('username'),
            passwordError:this.isFieldInError('password'),
        });
        if(!this.isFormValid()){
            return;
        }else{
            //if form field valid
            this.setState({
                showAlert: true,
                showModalProgress:true,
                modalTitle:"",
                modalMessage:"Logging..",
                closeOnTouchOutside: false,
            });
            if(this.context.isConnected){
                try{
                    const params={
                            email: this.state.username,
                            password: this.state.password
                    }
                    //console.log(params);
                    const response = await axios.post(HOST + '/login',qs.stringify(params));
                    //console.log(response);
                    if(response.status === 200){
                        if(response.data.login === true){
                            //alert(response.data.token);
                            if(response.data.token){
                                this.context.changeState('token',response.data.token);
                                this.context.storeData('token',response.data.token);

                                let decoded = jwt_decode(response.data.token);
                                this.context.changeState('name',decoded.name);
                                this.context.changeState('email',decoded.username);
                                this.context.changeState('appUrl',decoded.url);
                                this.context.changeState('isLoggedIn',true);
                            }else{
                                alert('Someting went wrong! Please restart the app');
                            }
                        }
                        else
                            this.setState({
                                showAlert: true,
                                showModalProgress:false,
                                modalTitle:"Wrong Credential",
                                modalMessage: response.data.message,
                                closeOnTouchOutside: true,
                            });

                    }else{
                        //request status is not  200
                        this.setState({
                            showAlert: true,
                            showModalProgress:false,
                            modalTitle:"Server error",
                            modalMessage: "Something went wrong in the server",
                            closeOnTouchOutside: true,
                        });
                    }
                }catch(error){
                    //console.log(error);
                    Alert.alert('Error','Something went wrong');
                }
            }else{
                //if network is not connected
                this.setState({
                    showAlert: true,
                    showModalProgress:false,
                    modalTitle:"Ooops !",
                    modalMessage:"No Internet Connection found\n Check your connection",
                    closeOnTouchOutside: true,
                });
            }
        }
    }
    _showInputError = (fieldName) =>{
        let text='';
        this.getErrorsInField(fieldName).map((test)=>{text=text+test+'\n'})
        this.setState({
            showAlert: true,
            showModalProgress:false,
            modalTitle:"Error",
            modalMessage:text,
            closeOnTouchOutside: true,
        })
    }
    
      
    _onSendOtp = async()=>{

        this.setState({
            showAlert: true,
            showModalProgress:true,
            modalTitle:"",
            modalMessage:"Sending OTP",
            closeOnTouchOutside: false,
        });
        if(this.context.isConnected){
            try{
                const params={
                        email: this.state.username,
                }
                //console.log(params);
                const response = await axios.post(HOST + '/forgot',qs.stringify(params));
                //console.log(response);
                if(response.status === 200){
                    if(response.data.success === true){
                        //alert(response.data.token);
                        //after sent otp
                        
                        this.setState({
                            showAlert: false,
                            showLoginPage: false,
                            showForgotPasswordPage:false,
                            showVerifyOtpPage:true,
                            showUpdatePasswordPage:false,
                        })
                    }
                    else
                        this.setState({
                            showAlert: true,
                            showModalProgress:false,
                            modalTitle:"Failed",
                            modalMessage: "Failed to send otp",
                            closeOnTouchOutside: true,
                        });

                }else{
                    //request status is not  200
                    this.setState({
                        showAlert: true,
                        showModalProgress:false,
                        modalTitle:"Server error",
                        modalMessage: "Something went wrong in the server",
                        closeOnTouchOutside: true,
                    });
                }
            }catch(error){
                //console.log(error);
                Alert.alert('Error','Something went wrong');
            }
        }else{
            //if network is not connected
            this.setState({
                showAlert: true,
                showModalProgress:false,
                modalTitle:"Ooops !",
                modalMessage:"No Internet Connection found\n Check your connection",
                closeOnTouchOutside: true,
            });
        }


    }

    _onVerifyOtp = async()=>{
        this.setState({
            showAlert: true,
            showModalProgress:true,
            modalTitle:"",
            modalMessage:"Verifying OTP",
            closeOnTouchOutside: false,
        });
        if(this.context.isConnected){
            try{
                const params={
                        email: this.state.username,
                        otp  : this.state.otp,
                }
                //console.log(params);
                const response = await axios.post(HOST + '/verify',qs.stringify(params));
                //console.log(response);
                if(response.status === 200){
                    if(response.data.success === true){
                        //alert(response.data.token);
                        //after sent otp
                        
                        this.setState({
                            showAlert:false,
                            showLoginPage: false,
                            showForgotPasswordPage:false,
                            showVerifyOtpPage:false,
                            showUpdatePasswordPage:true,
                        })
                    }
                    else
                        this.setState({
                            showAlert: true,
                            showModalProgress:false,
                            modalTitle:"Mismatch",
                            modalMessage: "Otp is incorrect",
                            closeOnTouchOutside: true,
                        });

                }else{
                    //request status is not  200
                    this.setState({
                        showAlert: true,
                        showModalProgress:false,
                        modalTitle:"Server error",
                        modalMessage: "Something went wrong in the server",
                        closeOnTouchOutside: true,
                    });
                }
            }catch(error){
                //console.log(error);
                Alert.alert('Error','Something went wrong');
            }
        }else{
            //if network is not connected
            this.setState({
                showAlert: true,
                showModalProgress:false,
                modalTitle:"Ooops !",
                modalMessage:"No Internet Connection found\n Check your connection",
                closeOnTouchOutside: true,
            });
        }
    }

    _onUpdatePassword = async()=>{
        this.setState({
            showAlert: true,
            showModalProgress:true,
            modalTitle:"",
            modalMessage:"Updating Password",
            closeOnTouchOutside: false,
        });
        if(this.context.isConnected){
            try{
                const params={
                        email       : this.state.username,
                        password    : this.state.password,
                        verified    : true
                }
                //console.log(params);
                const response = await axios.post(HOST + '/reset',qs.stringify(params));
                //console.log(response);
                if(response.status === 200){
                    if(response.data.success === true){
                        //alert(response.data.token);
                        //after sent otp
                        this.setState({
                            showAlert: true,
                            showModalProgress:false,
                            modalTitle:"Success",
                            modalMessage: 'Password updated successfully',
                            closeOnTouchOutside: false,
                            showConfirmButton:true,
                            confirmText:'Goto Login',
                            onConfirmPressed:()=>{
                                this.hideAlert();
                                this.setState({
                                    showLoginPage: true,
                                    showForgotPasswordPage:false,
                                    showVerifyOtpPage:false,
                                    showUpdatePasswordPage:false,
                                })
                            }
                        });

                    }
                    else
                        this.setState({
                            showAlert: true,
                            showModalProgress:false,
                            modalTitle:"Mismatch",
                            modalMessage: "Otp is incorrect",
                            closeOnTouchOutside: true,
                        });

                }else{
                    //request status is not  200
                    this.setState({
                        showAlert: true,
                        showModalProgress:false,
                        modalTitle:"Server error",
                        modalMessage: "Something went wrong in the server",
                        closeOnTouchOutside: true,
                    });
                }
            }catch(error){
                //console.log(error);
                Alert.alert('Error','Something went wrong');
            }
        }else{
            //if network is not connected
            this.setState({
                showAlert: true,
                showModalProgress:false,
                modalTitle:"Ooops !",
                modalMessage:"No Internet Connection found\n Check your connection",
                closeOnTouchOutside: true,
            });
        }
    }

    render() {
        const {colors} = this.props.theme;
        const {showAlert,showModalProgress,modalTitle,modalMessage,closeOnTouchOutside,usernameError,passwordError} = this.state;
        return (
            <KeyboardAvoidingView
                behavior={Platform.OS === "ios" ? "padding" : "height"}
                style={{flex:1}}
            >
                <View style={styles.container}>
                    <LinearGradient
                        // Background Linear Gradient
                        colors={['rgba(245,148,183,1)', 'rgba(173,127,251,1)','rgba(146,178,253,1)']}
                        style={styles.background}
                        end={{x:0.9,y:0.9}}
                    />

                    {
                        this.state.showLoginPage === true ?
                        
                            <View>
                                <Image style={styles.loginImage} resizeMode="contain" source={require('./../assets/loginimage.png')}/>
                                <Text style={styles.headingText}>Welcome Back !</Text>
                                <Text style={styles.subHeadingText}> Login to your existing account </Text>
                            </View>
                        :
                            <View>
                                <Image style={styles.loginImage} resizeMode="contain" source={require('./../assets/loginimage.png')}/>
                                <Text style={styles.headingText}>Forgot Password ?</Text>
                                <Text style={styles.subHeadingText}> Easily reset your password</Text>
                            </View>
                    }

                    
                    <View style={styles.inputContainer}>

                        {/*     Login      */}

                        {
                            this.state.showLoginPage === true || this.state.showForgotPasswordPage === true?
                                <TextInput
                                    style={[styles.inputStyle,{marginBottom:25}]}
                                    underlineColor={"transparent"}
                                    label="Email"
                                    value={this.state.username}
                                    onChangeText={this._onChangeUsername}
                                    left={
                                        <TextInput.Icon
                                        name = {()=><MaterialIcons name="email" size={20} color={colors.icon}/>}
                                        ></TextInput.Icon>
                                    }
                                    right={
                                        usernameError?
                                            <TextInput.Icon
                                            name = {()=>{
                                                return <Pressable onPress={()=>this._showInputError('username')}>

                                                            <MaterialIcons name="info" size={20} color='red'/>
                                                            </Pressable>}
                                                }
                                            ></TextInput.Icon>
                                        :
                                        null
                                    }
                                />
                            : null
                        }

                        {
                            this.state.showVerifyOtpPage === true ?
                                <TextInput
                                    style={[styles.inputStyle,{marginBottom:25}]}
                                    underlineColor={"transparent"}
                                    label="OTP"
                                    keyboardType='number-pad'
                                    value={this.state.otp}
                                    onChangeText={(text)=>this.setState({otp:text})}
                                    left={
                                        <TextInput.Icon
                                        name = {()=><MaterialIcons name="vpn-key" size={20} color={colors.icon}/>}
                                        ></TextInput.Icon>
                                    }
                                />
                            : null
                        }

                        {
                            this.state.showLoginPage === true || this.state.showUpdatePasswordPage === true ?
                        
                                <TextInput
                                    style={[styles.inputStyle,{marginBottom:5}]}
                                    underlineColor={"transparent"}
                                    label="Password"
                                    secureTextEntry
                                    value={this.state.password}
                                    onChangeText={this._onChangePassword}
                                    left={
                                        <TextInput.Icon
                                        name = {()=><MaterialIcons name="lock" size={20} color={colors.icon}/>}
                                        ></TextInput.Icon>
                                    }
                                    right={
                                        passwordError?
                                        <TextInput.Icon
                                        name = {()=>{
                                            return <Pressable onPress={()=>this._showInputError('password')}>

                                                        <MaterialIcons name="info" size={20} color='red'/>
                                                        </Pressable>}
                                            }
                                        ></TextInput.Icon>
                                        :
                                        null
                                    }

                                />
                            :null
                        }
                        {/*   End login Input    */}

                        
                        {
                            this.state.showLoginPage === true ?
                        
                                <View style={{alignItems:'flex-end'}}>
                                    <Pressable
                                        onPress={() => this.setState({showForgotPasswordPage:true,showLoginPage:false})}>
                                        <Text style={[styles.forgotPassword,{color:colors.primaryText}]}>Forgot Password ?</Text>
                                    </Pressable>
                                </View>
                            :null
                        }

                        {
                            this.state.showLoginPage === true ?
                        
                                <LinearGradient
                                    colors={['rgba(173,127,251,1)','rgba(146,178,253,1)']}
                                    end={{x:0.9,y:0.9}}
                                    style={[styles.buttonContainer,{marginBottom:20}]}>
                                    <Button style={styles.button} labelStyle={styles.buttonText} mode="text" color="#ffffff" onPress={this._onSubmit}>
                                        Log In
                                    </Button>
                                </LinearGradient>
                            :null
                        }

                        {
                            this.state.showForgotPasswordPage === true ?
                        
                                <LinearGradient
                                    colors={['rgba(173,127,251,1)','rgba(146,178,253,1)']}
                                    end={{x:0.9,y:0.9}}
                                    style={[styles.buttonContainer,{marginBottom:20}]}>
                                    <Button style={styles.button} labelStyle={styles.buttonText} mode="text" color="#ffffff" onPress={this._onSendOtp}>
                                        Send OTP
                                    </Button>
                                </LinearGradient>
                            :null
                        }

                        {
                            this.state.showVerifyOtpPage === true ?
                        
                                <LinearGradient
                                    colors={['rgba(173,127,251,1)','rgba(146,178,253,1)']}
                                    end={{x:0.9,y:0.9}}
                                    style={[styles.buttonContainer,{marginBottom:20}]}>
                                    <Button style={styles.button} labelStyle={styles.buttonText} mode="text" color="#ffffff" onPress={this._onVerifyOtp}>
                                        Verify OTP
                                    </Button>
                                </LinearGradient>
                            :null
                        }

                        {
                            this.state.showUpdatePasswordPage === true ?
                        
                                <LinearGradient
                                    colors={['rgba(173,127,251,1)','rgba(146,178,253,1)']}
                                    end={{x:0.9,y:0.9}}
                                    style={[styles.buttonContainer,{marginBottom:20,marginTop:15}]}>
                                    <Button style={styles.button} labelStyle={styles.buttonText} mode="text" color="#ffffff" onPress={this._onUpdatePassword}>
                                        Update Password
                                    </Button>
                                </LinearGradient>
                            :null
                        }
                        
                        <View style={{alignItems:'center', justifyContent:'center', flexDirection:'row',marginBottom:10}}>
                            <Text style={{fontSize:16}}>Don’t have an account ?</Text>
                            <Pressable
                                onPress={() => this.props.openSignUpPage()}>
                                <Text style={[styles.forgotPassword,{color:colors.primaryText,fontWeight:'bold'}]}> Sign Up</Text>
                            </Pressable>
                        </View>
                    </View>
                    <AwesomeAlert
                        show={showAlert}
                        showProgress={showModalProgress}
                        progressColor="#ff00ff"
                        title={modalTitle}
                        message={modalMessage}
                        closeOnTouchOutside={closeOnTouchOutside}
                        closeOnHardwareBackPress={false}
                        showCancelButton={false}
                        showConfirmButton={this.state.showConfirmButton}
                        cancelText="No, cancel"
                        confirmText={this.state.confirmText}
                        confirmButtonColor="#92B2FD"
                        onDismiss = {()=>{
                            this.setState({showAlert:false})
                        }}
                        onCancelPressed={() => {
                            this.hideAlert();
                        }}
                        onConfirmPressed={this.state.onConfirmPressed}
                        />
                </View>
            </KeyboardAvoidingView>
        )
    }
}

const styles = StyleSheet.create({
    container:{
        flex:1,
        flexWrap:'nowrap',
        justifyContent:'space-between',
        alignItems: 'center',
    },
    background:{
        flex:1,
        position:'absolute',
        height:'100%',
        width:'100%',
    },
    loginImage:{
        width:200,
    },
    headingText:{
        fontSize: 25,
        color: '#ffffff',
        fontWeight:'bold',
        fontFamily: 'Roboto',
        textAlign:'center',
    },
    subHeadingText:{
        fontSize: 16,
        color: '#ffffff',
        fontWeight:'normal',
        fontFamily: 'Roboto',
        textAlign:'center',
        marginBottom: 10,
    },
    inputContainer:{
        borderTopLeftRadius: 40,
        borderTopRightRadius: 40,
        paddingTop: 44,
        paddingLeft:30,
        paddingRight:30,
        width:'100%',
        backgroundColor: '#ffffff',
    },
    inputStyle:{
        height:50,
        backgroundColor:'#ffffff',
        borderRadius:40,
        borderTopRightRadius:40,
        borderTopLeftRadius:40,
        elevation:2,
        overflow:'hidden',
    },
    buttonContainer:{
        borderRadius:40,
        padding:9,
        marginLeft: 40,
        marginRight: 40,
    },
    button:{
        backgroundColor:'transparent'
    },
    buttonText:{
        fontSize: 16,
        fontWeight: 'bold',
        fontFamily: 'Roboto',
    },
    forgotPassword:{
        fontSize: 16,
        marginVertical: 5,
    }
});

SignIn.contextType = ERContext;

export default withTheme(SignIn)
