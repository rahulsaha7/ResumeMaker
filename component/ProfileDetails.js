import React, { Component } from 'react'
import { Text, View } from 'react-native'
import { FAB,List,TextInput, Button,HelperText  } from 'react-native-paper';
export default class ProfileDetails extends Component {
    render() {
        return (
            
        <List.Section title="Resume Details" style={{paddingHorizontal:15}}>
            <List.Accordion
                title="Profile Details"
                left={props => <List.Icon {...props} icon="account" />}
                style={{backgroundColor:'#0000ff22',borderTopLeftRadius:10,borderTopRightRadius:10,marginBottom:10}}
                >
                <View style={{backgroundColor:'#fff',paddingLeft:10,paddingHorizontal :10}}>

                <TextInput
                        underlineColor={"transparent"}
                        label="Username"
                        value="test"
                        style={{marginVertical:10}}
                        />
                        <TextInput
                        underlineColor={"transparent"}
                        label="Username"
                        value="test"
                        />
                </View>
                    
            </List.Accordion>

            <List.Accordion
                title="Education Details"
                left={props => <List.Icon {...props} icon="folder" />}
                style={{backgroundColor:'#0000ff22',borderTopLeftRadius:10,borderTopRightRadius:10,marginTop:10}}
                >
                <View style={{backgroundColor:'#fff',paddingLeft:10,paddingHorizontal :10}}>

                <TextInput
                        underlineColor={"transparent"}
                        label="Username"
                        value="test"
                        style={{marginVertical:10}}
                        />
                        <TextInput
                        underlineColor={"transparent"}
                        label="Username"
                        value="test"
                        />
                </View>
                    
            </List.Accordion>
        </List.Section>
        )
    }
}
